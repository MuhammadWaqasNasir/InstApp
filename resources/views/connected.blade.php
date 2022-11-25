<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instagram</title>
    {{-- css file --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <header>
        <div class="container">

            <div class="profile">
                <div class="profile-stats">
                    <ul>
                    <a class="profile-url" href="https://www.instagram.com/"{{ $data['username'] }}><li><span class="profile-stat-count">User Name:- </span> {{ $data['username'] }}</li></a>
                    </ul>
                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count">Posts:- </span> {{ $data['media_count'] }}</li>
                        <li><span class="profile-stat-count">Account Type:- </span> {{ $data['account_type'] }} </li>
                    </ul>
                </div>

            </div>
            <!-- End of profile section -->

        </div>
        <!-- End of container -->

    </header>

    <main>
        <div class="container">
            <hr class="black-line mb-5">
            <div class="row">
                <div class="center">
                    <h1>Images</h1>
                </div>
            </div>
            <div class="mt-5 d-flex-col-{{ $setting->col_no }}">
                @forelse ($f_images as $data)
                <a href="{{ $data->permalink }}" class=" {{ $setting->link_redirect ?  ''  : 'disabled' }}">
                    <div class="gallery-item" tabindex="0">
                        <img src="{{ $data->media_url }}" class="gallery-image" alt="Instagram Image">
                    </div>
                </a>
                @empty
                <h1>You don't have any image in your instagram account</h1>
                @endforelse
            </div>
            <hr class="black-line mb-5">
            <!-- End of gallery -->

            {{-- instagram video --}}

            <div class="row">
                <div class="container">
                    <div class="center">
                        <h1>Videos</h1>
                    </div>
                </div>
            </div>
            @forelse ($f_videos as $data)
            <a href="{{ $data->permalink }}" class=" {{ $setting->link_redirect ?  '' : 'disabled' }}">
                <div class="row mt-5">
                    <div class="center">
                        <video width="320" height="240" poster="{{ $data->thumbnail_url }}" controls>
                            <source src="{{ $data->media_url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </a>
            @empty
            <h1>You don't have any Video in your instagram account</h1>
            @endforelse
            <hr class="black-line mb-5">
            <div class="center mt-5">
                <h1>End of The Page</h1>
            </div>

        </div>
        <!-- End of container -->

    </main>
</body>

</html>
