@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-greetings />
                <div class="centre">
                    <a href="https://api.instagram.com/oauth/authorize?client_id={{ env('APP_ID') }}&redirect_uri={{ env('REDIRECT_URI') }}&scope=user_profile,user_media&response_type=code">
                        <button type="button" class="btn btn-success btn-lg">Connect with Instagram</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
