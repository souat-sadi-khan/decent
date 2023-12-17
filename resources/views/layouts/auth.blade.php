<!DOCTYPE html>
<html>
  <head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('backend/css/toastr.min.css')}}" rel="stylesheet">
    <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset(get_option('favicon')?'storage/logo/'.get_option('favicon'):'favicon.png')}}">

  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo text-center">
        @if(get_option('logo'))
          <img class="ml-4 " style="width: 100px;" src="{{asset('storage/logo')}}/{{get_option('logo')}}" alt="">
        @else 
          <img src="{{asset('logo.png')}}" alt="Company Logo">
        @endif
        
        <h1>{{get_option('site_title')?get_option('site_title'):'SATT'}}</h1>
        <div style="position: absolute;top: 55%;left: 48%;z-index:100; display: none;" id="loader">
          <img src="{{asset('img/loading.gif')}}" alt="">
        </div>
      </div>
      @section('auth')
      @show
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('backend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('backend/js/popper.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/page.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{asset('backend/js/plugins/pace.min.js')}}"></script>
    <script src="{{asset('backend/js/toastr.min.js')}}"></script>
    <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
    });
    </script>
    <script>
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    </script>
    @stack('scripts')
  </body>
</html>