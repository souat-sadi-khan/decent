@php
    $find_shiping_address = App\models\Production\Transaction::where('shipping_status', '!=', null)->first();
    if($find_shiping_address) {
        $x = 1;
    } else {
        $x = 0;
    }
@endphp

<div id="print_table" style="color:black">
    <span class="text-center">
     <p class="text-center">    <img style="width:100px;" alt="Brand Logo" src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/logo'. '/' . get_option('logo')) : asset('frontend/images/mt-logo.png') }}"> </p>
        <h3><b class="text-uppercase">{{ get_option('site_title') }}</b></h3>
        <h5> {{ get_option('description') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>Ecommerce Invoice</b></h4>
    </div>
    <br>
     <div class="row">
        <div class="col-md-6 text-justify">
            <p class="h3 font-weight-bold text-uppercase text-color"> Invoice To</p>
            @if ($x != 1)
                <p class="text-justify"><span class="font-weight-bold d-inline-block text-color "> Name : {{ get_client_name($model->client_id) }} </span></p>
                <p> <span class="font-weight-bold text-color text-justify"> Address : {{ get_client_address($model->client_id) }} </span></p>
                <p class="text-justify"> <span class="font-weight-bold text-color"> E-mail  : {{ $model->client->email }} </span></p>
                <p><span class="font-weight-bold text-color"> Contact : {{ $model->client->mobile }} </span>  </p>
            @else 
                <p class="text-justify"><span class="font-weight-bold d-inline-block text-color "> Name : {{ $find_shiping_address->full_name }} </span></p>
                <p> <span class="font-weight-bold text-color text-justify"> Address : {{ $find_shiping_address->address }} {{ $find_shiping_address->city}} </span></p>
                <p class="text-justify"> <span class="font-weight-bold text-color"> E-mail  : {{ $find_shiping_address->email }} </span></p>
                <p><span class="font-weight-bold text-color"> Contact : {{ $find_shiping_address->phone }} </span>  </p>
            @endif
        </div>
        <div class="col-md-6 text-right">
            <p class="">
                <span class="font-weight-bold text-right text-uppercase h5"> Invoice No : #{{ $model->invoice_no }} </span>
                
            </p>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td>

                        <p style="margin:0px ; margin-top: -8px;">

                            Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>

                        </p>

                    </td>
                    <td class="text-center">

                    </td>
                    <td class="text-right">
                        <p style="margin:0px ; margin-top: -8px;">Printing Date :
                            <span></span> {{ date('d F, Y') }} </span></p>
                        <p style="margin:0px ; margin-top: -4px;">Time :
                            <span></span>{{date('h:i:s A')}}</span></p>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="tavle-responsice col-md-12">
        {{-- <h6 class="text-center py-2">{{ formatDate($start_date) }}-{{ formatDate($end_date) }} </h6> --}}
        <table class="table table-bordered table-striped table-sm">
            <thead class="table-info"> 
                <tr>
                    <th>Sl</th>
                    <th>Name</th>
                    <th>Quantity.</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model->sell_lines as $element)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $element->variation->name }}-{{ $element->product->name }}</td>
                    <td>{{ $element->quantity }}</td>
                    <td>{{ $element->unit_price }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ($model->return==1)
                <tr>
                    <td colspan="4"> <small>Sale Has Return</small></td>
                </tr>
                   
                @endif
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Sub Total') }}</td>
                    <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->sub_total }} </td>
                </tr>
                @if ($model->discount)
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Discount Amount') }}</td>
                    <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->discount_amount }} </td>
                </tr>
                @endif
            
                @if ($model->tax)
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Discount Amount') }}</td>
                    <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->tax }} </td>
                </tr>
                @endif
            
                @if ($model->shipping_charges)
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Shipping Charge') }}</td>
                    <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->shipping_charges }} </td>
                </tr>
                @endif
            
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Net Total') }}</td>
                    <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->net_total }} </td>
                </tr>
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Paid') }}</td>
                    <td>  {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{ $model->paid == '' ? 0 : $model->paid }} </td>
                </tr>
                <tr>
                    <td class="text-right h5 font-weight-bold" colspan="3"> {{ _lang('Payment Method') }}</td>
                    <td> {{ $model->payment_status == 'cash_on_delivery' ? 'Cash On Delivery' : $model->payment_status }} </td>
                </tr>
            </tfoot>
        </table>
    </div>


   
    <br>
    {{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
    <br><br><br>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-4 text-center">
            <hr class="border-dark">
            <p> Chief Cashier </p>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 text-center">
            <hr class="border-dark">
            <p> Manager </p>
        </div>
        <div class="col-md-1"></div>


    </div>


</div>

<div class="text-center mb-3">
    @php
    $print_table = 'print_table';

    @endphp

    <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
        id="print_receipt">
        <i class="fa fa-print" aria-hidden="true"></i>
        Print Report

    </a>
</div>
    
<script>
    function printContent(el) {
        console.log('print clicked');

        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        return window.location.reload(true);

    }
</script>