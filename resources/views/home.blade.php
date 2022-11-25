@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <x-greetings />
                    {{ __('You are logged in!') }}

                    <form class="form-group " action="{{ route('update-settings') }}" method="POST">

                        @csrf
                        <div class="row m-t-5">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="col-8 item">
                                        <label for="imgaes_per_page" class="form-lable">Number Of Images in a
                                            Page</label>
                                    </div>
                                    <div class="col-4 item">
                                        <input id="imgaes_per_page" class="form-control" value="{{ $data->max_images }}"
                                            type="number" name="imgaes_per_page" required max="20" min="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="col-8 item">
                                        <label for="videos_per_page" class="form-lable">Number Of Videos in a
                                            Page</label>
                                    </div>
                                    <div class="col-4 item">
                                        <input id="videos_per_page" class="form-control" value="{{ $data->max_videos }}"
                                            type="number" name="videos_per_page" required max="10" min="4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="col-8 item">
                                        <label for="coloums_per_page" class="form-lable"> Number Of Coloums in a
                                            Page</label>

                                    </div>
                                    <div class="col-4 item">
                                        <input id="coloums_per_page" class="form-control" value="{{ $data->col_no }}"
                                            type="number" name="coloums_per_page" required max="5" min="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="col-8 item">
                                        <label class="form-check-label" for="redirect_link">Redirect to orignal
                                            source</label>
                                    </div>
                                    <div class="col-4 item">
                                        <input type="checkbox" value="1" class="form-check-input" id="redirect_link"
                                            name="redirect_link" {{ $data->link_redirect ? 'checked="checked"' : '' }}/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="token">
                                <div class="">Connected Instagram Long term access token:- </div>
                                <textarea name="" id="" cols="90" rows="3" disabled>{{ (session()->get('long_term_access_token'))? session()->get('long_term_access_token') : 'Instagram is not connected yet' }}</textarea>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
