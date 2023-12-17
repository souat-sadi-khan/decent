
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

<style>
    
   .table-light tbody+tbody, .table-light td, .table-light th, .table-light thead th {
   border-color: #bdbdbd;
   }
   .table-light, .table-light>td, .table-light>th {
   background-color: #ebeefd;
   }

   .table td, .table th {
    padding: .3rem .75rem;
   }

   @media print {
       
   table thead.bg-primary{
   background-color: #007bff!important;
   }
    
    .table thead th {
    background-color: #007bff!important;
}
       
    .table td {
   background-color: #ebeefd !important;
   }   
    .table th {
   background-color: #ebeefd !important;
   }
    
       .fotter-bottom{
           position: absolute;
           bottom: 0;
           left: 0;
           right: 0;
       }
    
   }
    
</style>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-primary py-2">
                    <p class="text-uppercase h5 text-center text-light font-weight-light mb-0"> Invoice </p>
                </div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <div class="mt-logo">
                    <img style="width:100px;" alt="Brand Logo" src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/logo'. '/' . get_option('logo')) : asset('frontend/images/mt-logo.png') }}">
               </div>
                <p class="h2 text-primary"> {{get_option('site_title')}} </p>
                <p class="mb-1">Order Invoice</p>
                <p class="mb-1"> {{get_option('address')}} </p>
                <p class="mb-1"> {{get_option('city')}} </p>
                <p class="mb-1"> {{get_option('country')}} </p>
                <p class="mb-1"> {{get_option('zip')}} </p>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1 font-weight-bold"> BILL TO : </p>
                <p class="h5"> {{$client->name }} {{ $client->last_name }} </p>
                <p class="mb-1"> {{ $client->address }} </p>
                <p class="mb-1"> {{ $client->city }} </p>
                <p class="mb-1"> {{ $client->post_code }} </p>
                <p class="mb-1"> {{ $client->state}} ,Bangladesh </p>
            </div>
            <div class="col-md-6 text-right">
                <p class="mb-1 font-weight-bold text-uppercase"> Invoice# </p>
                <p class="mb-1 "> {{$transaction->invoice_no}} </p>
                <p class="mb-1 font-weight-bold text-uppercase"> Date </p>
                @php
                    $date = explode(" ",$transaction->updated_at)
                @endphp
                <p class="mb-1"> {{$date[0]}} </p>
            </div>
        </div>
        <div class="row"> 
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-uppercase" scope="col" > Items </th>
                        <th class="text-uppercase w-50" scope="col" > Product Name </th>
                        <th class="text-uppercase" scope="col" > quantity </th>
                        <th class="text-uppercase" scope="col" > price </th>
                        <th class="text-uppercase" scope="col" > Amount </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction_sale as $key => $item)
                    <tr class="table-light">
                        <th scope="row">Item {{$key+1}}</th>
                        <td> {{$item->product->name}} </td>
                        <td> {{$item->quantity}} </td> 
                        <td class="text-right"> {{ get_option('currency') }} {{$item->unit_price}} </td>
                        <td class="text-right"> {{ get_option('currency') }} {{$item->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Subtotal</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }} {{ $transaction->sub_total != null ? number_format($transaction->sub_total, 2) : '0.00'}} </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Coupon Amount</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }} {{ $transaction->discount != null ? number_format($transaction->discount, 2) : '0.00'}} </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Shipping Charges</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }} {{ $transaction->shipping_charges != null ? number_format($transaction->shipping_charges, 2) : '0.00'}} </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Paid</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }} {{ $transaction->paid != null ? number_format($transaction->paid, 2) : '0.00'}} </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Due</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }}{{ $transaction->due != null ? number_format($transaction->due, 2) : '0.00'}} </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Net Total</th>
                        <td colspan="1" class="text-right">{{ get_option('currency') }} {{ $transaction->net_total != null ? number_format($transaction->net_total, 2) : '0.00'}} </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
    
    <div class="container-fluid fotter-bottom">
        <div class="row mt-3 mb-5">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
                  <p class="text-uppercase font-weight-bold"> total </p>
                  <p class="h1 text-primary">  {{ get_option('currency') }} {{number_format($transaction_sale->sum('total'), 2)}}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 text-center mx-auto">
                <span class="font-weight-bold"> Power By &nbsp; </span> 
                <img src="Logo2.png" alt="" style="width: 120px">
                <p> <small>© {{date('Y')}} decentfootware.com, All Rights Reserved</small></p>
            </div>
        </div>
        
    </div>
   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>