<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta name="description" content="Decent Footware.">
        <!-- Twitter meta-->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:site" content="@pratikborsadiya">
        <meta property="twitter:creator" content="@pratikborsadiya">
        <!-- Open Graph Meta-->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Decent Footware">
        <meta property="og:title" content="Decent Footware">
        <meta property="og:url" content="http://decent.sattproject.xyz">
        <meta property="og:image" content="http://decent.sattproject.xyz">
        <meta property="og:description" content="Decent Footware.">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset(get_option('favicon')?'storage/logo/'.get_option('favicon'):'favicon.png')}}">
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('backend/css/main.css')}}">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('backend/css/dropify.min.css')}}">
        <link href="{{asset('backend/css/summernote-bs4.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('backend/css/parsley.css')}}">
        <link rel="stylesheet" href="{{ asset('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css') }}">
        <link href="{{asset('backend/css/toastr.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/css/time.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">

        <style>
            .pageloader {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('{{asset('pageloader.gif')}}') 50% 50% no-repeat rgb(249,249,249);
                background-size: 8%;;
                opacity: .7;
            }
        </style>
        <!-- /global stylesheets -->
        @stack('admin.css')
    </head>
    <body class="app sidebar-mini rtl {{get_option('default_sidebar') == '0' ||Request::is('admin/sale/pos/create') ? 'sidenav-toggled':''}}" >
        <div class="pageloader" style="display: none"></div>
        <!-- Navbar-->
        @include('_partials.admin.navbar')
        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        @include('_partials.admin.sidebar')
        <main class="app-content">
            <div style="position: absolute;top: 55%;left: 50%;z-index:100; display: none;" id="loader">
                <img src="{{asset('img/loading.gif')}}" alt="">
            </div>
            @section('page.header')
            @show
            @section('content')
            @show
        </main>
        <!-- /page content -->
        @if(isset($modal))
        <!-- Remote source -->
        <div id="modal_remote" class="modal fade border-top-success rounded-top-0" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-{{ $modal }} modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light border-grey-300">
                        <h5 class="modal-title">{{$title}}</h5>
                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                    </div>
                    <div id="modal-loader" style="display: none; text-align: center;"><img
                            src="{{ asset('img/loading.gif') }}"></div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        <!-- /remote source -->
    @endif
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('backend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('backend/js/popper.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/page.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{asset('backend/js/plugins/pace.min.js')}}"></script>
    <script src="{{ asset('backend/js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/sweetalert.min.js')}}"></script>
    <script src="{{asset('backend/js/dropify.min.js')}}"></script>
    <script src="{{asset('backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('backend/js/toastr.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-ui.js')}}"></script>
    <script src="{{asset('backend/js/plugins/clock.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        toastr.options = {"positionClass": "{{get_option('notification_format')}} ",   "preventDuplicates": true,};


        $(document).ready(function () {
            var customtimestamp = parseInt($("#jqclock").data("time"));
            $("#jqclock").clock({"langSet": "en"});
            $("#jqclock-local").clock({"langSet": "en"});
        });
    </script>
    <script src="{{asset('js/main.js')}}"></script>
    <!-- /core JS files -->
    @stack('scripts')
</body>
</html>
