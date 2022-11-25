<?php

namespace App\Http\Controllers;

use View;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSettingRequest;
use Psy\Util\Json;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->app_key = env('APP_ID');
        $this->client_secret_key = env('APP_SECRET_KEY');
        $this->redirect_uri = env('REDIRECT_URI');
        $this->short_access_token = "";
        $this->long_term_access_token = "";
    }


    public function update(UpdateSettingRequest $request)
    {
        try {
            Setting::where(
                ['id' => 1]
            )->update([
                'max_images' => $request->imgaes_per_page,
                'max_videos' => $request->videos_per_page,
                'col_no' => $request->coloums_per_page,
                'link_redirect' => $request->redirect_link,
            ]);
            return redirect()->back()->with('success', 'Record is updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong. Please check your data and try again');
        }
    }


    public function callback(Request $request)
    {
        try {
            // api call to get access token and user_id
            $code =  str_replace("#_", "", $request->code);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/oauth/access_token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post = array(
                'client_id' => $this->app_key,
                'client_secret' => $this->client_secret_key,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->redirect_uri,
                'code' => $code
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $result = json_decode($result);

            $this->short_access_token = $result->access_token;

            // get long term access token
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=ca06bffd69fd5c5c04acff6e9b1c9c44&access_token=' . $this->short_access_token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $result = json_decode($result);

            $this->long_term_access_token = $result->access_token;
            // store data in session for later use because here we are not saving the data in database
            session(['short_term_access_token' => $this->short_access_token]);
            session(['long_term_access_token' => $this->long_term_access_token]);
            return redirect()->route('connected');
        } catch (\Exception $e) {
            return redirect()->route('oauth-error');
        }
    }

    public function errorHandling(Request $request)
    {
        return redirect()->route('welcome')->with('error', 'Oops! Something went wrong. Please try again');
    }

    public function connected(Request $request)
    {
        try {
            $setting = Setting::find(1);
            $long_term_access = session()->get('long_term_access_token');
            // we can refresh the long term access token by using this call

            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $long_term_access);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // $result = curl_exec($ch);
            // if (curl_errno($ch)) {
            //     echo 'Error:' . curl_error($ch);
            // }
            // curl_close($ch);
            // $response = json_decode($result);

            // get the user profile id , user name and some other data
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://graph.instagram.com/me?fields=id,username,account_type,media_count&access_token=' . $long_term_access);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $result = json_decode($result);
            // storing data in organized way in a var to access in blade
            $data['id'] = $result->id;
            $data['username'] = $result->username;
            $data['account_type'] = $result->account_type;
            $data['media_count'] = $result->media_count;

            // get the user profile media . this call will return us the id of the media and some other data
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,username&access_token=' . $long_term_access);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $result = json_decode($result);
            //differentiate the video and images and ignore useless data
            for ($i = 0; $i <= count($result->data) - 1; $i++) {
                if ($result->data[$i]->media_type == "IMAGE") {
                    $images[] = $result->data[$i];
                } elseif ($result->data[$i]->media_type == "VIDEO") {
                    $videos[] = $result->data[$i];
                } else {
                    //ignore the data
                }
            }

            // filter the data length according to the settings
            for ($i = 0; $i <= $setting->max_images-1; $i++) {
                @$f_images[] = $images[$i];
            }
            for ($i = 0; $i <= $setting->max_videos-1; $i++) {
                @$f_videos[] = $videos[$i];
            }

            // ignore the empty arrays
            $f_videos = array_filter($f_videos);
            $f_images = array_filter($f_images);
            $setting = Setting::find(1);
            return view('connected', compact('setting', 'data', 'f_images', 'f_videos'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oops! Something went wrong. Please connect your account again');
        }
    }
}
