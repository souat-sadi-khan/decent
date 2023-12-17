<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <style>
        .bg-color {
            background: #0EA6E0;
            padding: 30px 0px;
            border-bottom-left-radius: 170px;
            border-bottom-right-radius:170px;
        }

        .img-border {
            border: solid 4px #fff;
            width: 150px;
            height: 150px;
            z-index: 999;
        }

        .hr-box {
            width: 50px;
            text-align: center;
            margin: auto;
        }

        .hr-1 {
            border-bottom: solid 2px #0EA6E0;
            margin: 4px 0px;
        }

        .text-color {
            color: #0EA6E0;
        }

        .img-box {
            position: relative;
            bottom: -55px;
        }

        th {
            text-align: right;
            color: #0EA6E0;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
        }

        .table td,
        .table th {
            padding: .45rem;
            vertical-align: top;
             border-top: 0px solid transparent; 
        }

    </style>
    <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
</head>

<body class="vh-100">
    <div class="container">
        @section('content')
            @show
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
