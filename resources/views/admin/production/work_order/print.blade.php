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
                <p class="text-primary h2 mb-0"> <i class="fas fa-cart-plus"></i> </p>
                <p class="h2 text-primary"> {{ get_option('site_title') }}</p>
                <p class="mb-1"> Work Order Transaction Invoice </p>
                <p class="mb-1"> {{ get_option('address') }} </p>
                <p class="mb-1"> {{ get_option('city') }} {{ get_option('state') }} {{ get_option('zip')}} </p>
                <p class="mb-1"> {{ get_option('country') }} </p>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1 font-weight-bold"> BILL TO : </p>
                @if ($brand)
                    <p class="h5"> {{ $brand->name }} </p>
                    <p class="mb-1"> {{ $brand->owner_name }} </p>
                    <p class="mb-1"> {{ $brand->email }} </p>
                    <p class="mb-1"> {{ $brand->phone }} </p>
                    <p class="mb-1"> {{ $brand->address }} </p>
                @endif
            </div>
            <div class="col-md-6 text-right">
                <p class="mb-1 font-weight-bold text-uppercase"> Invoice# </p>
                <p class="mb-1 "> {{ $model->reference_no }} </p>
                <p class="mb-1 font-weight-bold text-uppercase"> Date </p>
                <p class="mb-1"> {{ formatDate(date('d-m-Y')) }} </p>
                <p class="mb-1 font-weight-bold text-uppercase"> Transaction Date </p>
                <p class="mb-1"> {{ formatDate($model->date) }} </p>
            </div>
        </div>
        <div class="row"> 
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-uppercase" scope="col" > Artical </th>
                        <th class="text-uppercase" scope="col" > Product </th>
                        <th class="text-uppercase w-50" scope="col" > Variation </th>
                        <th class="text-uppercase" scope="col" > Quantity </th>
                        <th class="text-uppercase" scope="col" > Price </th>
                        <th class="text-uppercase" scope="col" > Amount </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lines as $item)
                        <tr class="table-light">
                            <th>{{ $item->product->articel }} </th>
                            <th scope="row">{{ $item->product->name }}</th>
                            <td> {{ $item->variation->name }} </td>
                            <td> {{ $item->qty }}<small>pcs</small> </td> 
                            <td> {{ get_option('currency') }} {{ number_format($item->price, 2) }} </td>
                            <td> {{ get_option('currency') }} {{ number_format($item->sub_total, 2) }} </td>
                         </tr>   
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Discount Amount</th>
                        <td> {{ get_option('currency') }} {{ number_format($work_order->discount_amount, 2) }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Discount Type</th>
                        <td> {{ $work_order->discount_type == 'fixed' ? 'Fixed' : 'Percentages' }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Tax Amount</th>
                        <td> {{ get_option('currency') }} {{ number_format($work_order->tax, 2) }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Shiping Charge</th>
                        <td> {{ get_option('currency') }} {{ number_format($work_order->shiping_charge, 2) }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Total Paid</th>
                        <td> {{ get_option('currency') }} {{ number_format($work_order->paid, 2) }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Total Due</th>
                        <td> {{ get_option('currency') }} {{ number_format($work_order->due, 2) }} </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Payment Method</th>
                        <td> 
                            @if ($work_order->method == 'cash')
                                Hand Cash
                            @elseif( $work_order->method == 'other')
                                Other Payment Option 
                            @else 
                                Cheque Payment 
                            @endif    
                        </td>
                    </tr>
                    @if ($work_order->method != 'cash')
                        <tr>
                            <th colspan="5" class="text-right">Refer. Info</th>
                            <td>{{ $work_order->check_no }} </td>
                        </tr>
                    @endif
                </tfoot>
            </table>
        </div>
        </div>
    </div>
    
    <div class="container-fluid fotter-bottom">
        <div class="row mt-3 mb-5">
            <div class="col-md-6">
                <p class="text-uppercase font-weight-bold"> notes : </p>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum soluta laborum ut similique, accusantium, libero ducimus possimus incidunt voluptatem hic ipsa itaque. </p>
            </div>
            <div class="col-md-6 text-right">
                  <p class="text-uppercase font-weight-bold"> total </p>
                  <p class="h1 text-primary"> {{ get_option('currency') }} {{ number_format($model->net_total, 2) }} </p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 text-center mx-auto">
                <span class="font-weight-bold"> Power By &nbsp; </span> 
                <img src="Logo2.png" alt="" style="width: 120px">
                <p> <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error quod modi maiores expedita explicabo dolor.</small></p>
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