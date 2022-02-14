@extends('layouts.default')

@section('title','Login')

@push('css')
    <!-- Icon Font -->
    <link rel="stylesheet" href="{{ asset('fonts/ionicons/css/ionicons.css') }}">
    <!-- Text Font -->
    <link rel="stylesheet" href="{{ asset('fonts/font.css') }}">
    <!-- Normal style CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">
    <!-- Normal media CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth/media.css') }}">
@endpush

@section('content')
    <main class="cd-main">
        <section class="cd-section index2 visible">
            <div class="cd-content style2">
                <div class="login-box">
                    <div class="login-form-slider">
                        <!-- login slide start -->
                        <login-component name="{{ env('APP_NAME') }}"></login-component>
                        <!-- login slide end -->
                        <!-- forgot password slide start -->
                        <div class="forgot-password-slide slide">
                            <div class="d-flex height-100-percentage">
                                <div class="align-self-center width-100-percentage">
                                    <h3>Forgot Password</h3>
                                    <form>
                                        <label class="label">Enter your email address to reset your password</label>
                                        <div class="form-group user-name-field">
                                            <input type="text" class="form-control" placeholder="Email">
                                            <div class="field-icon"><i class="ion-ios-email"></i></div>
                                        </div>
                                        <div class="form-group sign-in-btn">
                                            <input type="submit" class="submit" value="Submit">
                                        </div>
                                    </form>
                                    <div class="sign-up-txt">
                                        if you remember your password? <a href="javascript:;" class="login-click">login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- forgot password slide end -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div id="cd-loading-bar" data-scale="1"></div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('js/auth/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/auth/velocity.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/auth/script.js') }}"></script>
    <script type="text/javascript">
        window.homeUrl = "{{ env('APP_URL') }}";
    </script>
@endpush
