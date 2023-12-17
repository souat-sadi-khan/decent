
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset(get_option('favicon')?'storage/logo/'.get_option('favicon'):'favicon.png')}}">
    
   <style>
               table {
            background-image: url(logo.png);
            background-size: cover;
            background-position: center;
        }

        .table-danger,
        .table-danger>td,
        .table-danger>th {
            background-color: rgba(245, 198, 203, 0.6);
        }

        .table-warning,
        .table-warning>td,
        .table-warning>th {
            background-color: rgba(255, 238, 186, 0.6);
        }

        .table-success,
        .table-success>td,
        .table-success>th {
            background-color: rgba(195, 230, 203, 0.6);
        }

        .table-info,
        .table-info>td,
        .table-info>th {
            background-color: rgba(190, 229, 235, 0.6);
        }

        .footer-bg {
            background: linear-gradient(90deg, rgba(47, 126, 187, 1) 0%, rgba(105, 53, 63, 1) 100%);
            height: 50px;
            width: 100%;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            font-size: 24px;
            text-align: center;
        }

        * {
            border-color: #69353f !important;
        }

        .header-top {
            border-bottom: solid 6px #262626 !important;
        }

        .text-color {
            color: #69353f;
        }


        @media print {

            table {
                background-image: url(logo.png);
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
            }

            .table-danger,
            .table-danger>td,
            .table-danger>th {
                background-color: rgba(245, 198, 203, 0.6) !important;
            }

            .table-warning,
            .table-warning>td,
            .table-warning>th {
                background-color: rgba(255, 238, 186, 0.6) !important;
            }

            .table-success,
            .table-success>td,
            .table-success>th {
                background-color: rgba(195, 230, 203, 0.6) !important;
            }

            .table-info,
            .table-info>td,
            .table-info>th {
                background-color: rgba(190, 229, 235, 0.6) !important;
            }

            .table-warning tbody+tbody,
            .table-warning td,
            .table-warning th,
            .table-warning thead th {
                border-color: #69353f !important;
            }

            .table-bordered td,
            .table-bordered th {
                border: 1px solid #69353f !important;
            }

            .footer-bg {
                background: linear-gradient(90deg, rgba(47, 126, 187, 1) 0%, rgba(105, 53, 63, 1) 100%);
                height: 50px;
                width: 100%;
            }

            .table-bordered thead td,
            .table-bordered thead th {
                font-size: 24px;
                text-align: center;
            }

            * {
                border-color: #69353f !important;
            }

            .header-top {
                border-bottom: solid 6px #262626 !important;
            }

            .text-color {
                color: #69353f;
            }

        }
   </style>
</head>

<body>
   <section class="header-top">
        <p class="h1 text-right mr-5 text-color"> BILL </p>
    </section>
    @yield('content')
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
    <script src="{{asset('backend/js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('backend/js/popper.min.js')}}"></script>
        <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
</body>
</html>
