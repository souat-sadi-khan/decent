
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset(get_option('favicon')?'storage/logo/'.get_option('favicon'):'favicon.png')}}">
    
    <style>
        .footer-bg {
            background: linear-gradient(90deg, rgba(47, 126, 187, 1) 0%, rgba(105, 53, 63, 1) 100%);
            height: 50px;
            width: 100%;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            font-size: 20px;
            text-align: center;
        }

        * {
            border-color: #000 !important;
        }

        .header-top {
            border-bottom: solid 3px #69353f !important;
        }

        .text-color {
            color: #69353f;
        }

        .table td,
        .table th {
            padding: .45rem;
        }

        thead {
            background-color: #b75568;
            color: #fff;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 1px;
        }


        @media print {



        }


        

    </style>
</head>

<body>
    <section class="header-top text-center">
        <p class="h2 text-center text-color mb-3">Decent Footwear LTD </p>
        <p class="text-center mb-0"> 67, Nayapaltan City Heart 12/6, Dhaka-1000</p>
        <p> Print Date :11-03-2020</p>
        <p class="text-center"> <span class="border rounded-pill px-4 py-2 border-dark font-weight-bold"> {{ isset($report_title)?$report_title:'' }} </span> </p>
    </section>
   @yield('content')


    <section class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 border-bottom pb-2 border-dark">
                    <img class="w-25" src="logo.png" alt="">
                </div>
            </div>
            <div class="row mt-3 mb-2">
                <div class="col-md-3 ">
                    <div class="row">
                        <div class="col-2">
                            <p class="mb-0 h6">Tel</p>
                        </div>
                        <div class="col-1">
                            <p class="mb-0 h6">:</p>
                        </div>
                        <div class="col-8 text-right">
                            <p class="mb-0 h6">+880-02-9346671</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <p class="mb-0 h6">Fax</p>
                        </div>
                        <div class="col-1">
                            <p class="mb-0 h6">:</p>
                        </div>
                        <div class="col-8 text-right">
                            <p class="mb-0 h6">+880-02-9342894 </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <p class="mb-0 h6">Mob </p>
                        </div>
                        <div class="col-1">
                            <p class="mb-0 h6">:</p>
                        </div>
                        <div class="col-8 text-right">
                            <p class="mb-0 h6">+880-01740940612 </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p class="mb-0 h6"> </p>
                        </div>
                        <div class="col-1">
                            <p class="mb-0 h6"> </p>
                        </div>
                        <div class="col-8 text-right">
                            <p class="mb-0 h6">+880-01740940612 </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="mb-0 h6"> Head Office : 67, Nayapaltan</p>
                    <p class="mb-0 h6"> City Heart 12/6, Dhaka-1000 </p>
                    <p class="mb-0 h6"> Factory : 143/1, Hazaribagh </p>
                    <p class="mb-0 h6"> Dhaka- 1209 , Bangladesh</p>
                </div>
                <div class="col-md-4">
                    <p></p>
                    <p class="mb-0 h6"> Website : www.decentfootwear.com</p>
                    <p class="mb-0 h6"> <img src="facebook.svg" alt="" style="width: 20px"> decentfootwearltd</p>
                    <p class="mb-0 h6"> Email : decentfootwearltd@hotmail.com</p>
                </div>
                <div class="col-md-2 text-right">
                    <img class="w-100" src="logo2.png" alt="">
                </div>
            </div>
        </div>
        <section class="footer-bg">

        </section>
    </section>
    <script src="{{asset('backend/js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('backend/js/popper.min.js')}}"></script>
        <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
</body>
</html>
