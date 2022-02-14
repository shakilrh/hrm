<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ settings('application_name') }}</title>
    <link rel="icon" href="{{ Storage::disk('public')->url(settings('favicon')) }}" type="image/x-icon">
    <!-- Fonts -->
    <link href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @stack('css')
</head>
<body class="hold-transition {{ Request::is('login') ? 'login-page' : 'sidebar-mini' }}
                             {{ Request::is('register') ? 'register-page' : 'sidebar-mini' }}">
<div id="app">
        <div class="wrapper">
            {{-- Navbar --}}
            @include('layouts.partials.header')
            {{-- Main Sidebar Container --}}
            @include('layouts.partials.sidebar')
            {{-- Content Wrapper. Contains page content --}}
            <div class="content-wrapper">
                @yield('content', 'Default Content')
            </div>
            {{-- Main Footer --}}
            @include('layouts.partials.footer')
        </div>
        <vue-progress-bar></vue-progress-bar>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bundle.js') }}"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script type="text/javascript">
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.closeMethod = 'slideUp';
</script>
@if($errors->any())
    <script type="text/javascript">
    @foreach($errors->all() as $error)
        toastr.error('{{ $error }}','Error',{
            closeButton:true,
            progressBar:true,
        });
    @endforeach
    </script>
@endif
@stack('js')
</body>
</html>
