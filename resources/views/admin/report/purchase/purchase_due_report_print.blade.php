<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5>  {{ _lang('Purchase Due Report') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>  {{ _lang('Purchase Due Report') }}</b></h4>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table">
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
    <div class="table-responsive">
        <table class="table table-hover table-sm table-bordered content_managment_table">
             <thead>
                 <tr>
                    <th scope="col">{{ _lang('Ref No') }}</th>
                    <th scope="col">{{ _lang('Client') }}</th>
                    <th scope="col">{{ _lang('Product') }}</th>
                    <th scope="col">{{ _lang('Payment Status') }}</th>
                    <th scope="col">{{ _lang('Sold By') }}</th>
                    <th scope="col">{{ _lang('Date') }}</th>
                    @can('view_purchase.price')
                    <th scope="col">{{ _lang('Net Total') }}</th>
                    @endcan
                    @can('view_purchase.paid')
                    <th scope="col">{{ _lang('Paid') }}</th>
                    @endcan
                    @can('view_purchase.due')
                    <th scope="col">{{ _lang('Due') }}</th>
                    @endcan
                </tr>
            </thead>   
             <tbody>

                @php
                    $total_quantity=0;
                @endphp
                @foreach ($result as $element)
                <tr>
                    <th>{{ $element->reference_no }}</th>
                    <th>{{ $element->employee?$element->employee->name:'' }}</th>
                    <td>
                        <ol>
                            @foreach($element->purchase as $pur)
                                <li>
                                    @php 
                                        $total_quantity = $total_quantity + $pur->qty;
                                    @endphp
                                    {{ $pur->product->name }}-{{$pur->material->name}}
                                    (   
                                      {{$pur->qty}} 
                                    )
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ $element->payment_status }}</td>
                    <td>
                        {{ $element->created_person?$element->created_person->email:'' }}
                        
                    </td>
                    <td>
                        {{ formatDate($element->date) }}
                    </td>
                    @can('view_purchase.price')
                    <td>
                        {{ $element->net_total }}
                    </td>
                    @endcan
                    @can('view_purchase.paid')
                    <td>
                        {{ $element->payment->sum('amount') }}
                    </td>
                    @endcan
                    @can('view_purchase.due')
                    <th>{{ $element->net_total-$element->payment->sum('amount') }}</th>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
            <table style="width: 50%; font-weight: bold;" align="right" class="table table-bordered visible-lg">

              @can('view_sale.sale_discount')
            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{ _lang('Discount Amt')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('discount_amount'),2)}}
                </td>
            </tr>
            @endcan
            @can('view_sale.sale_tax')
            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Total Tax')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('tax'))}} 
                </td>
            </tr>
            @endcan
            @can('view_sale.shipping_charge')
            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Shipping Charge')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('shipping_charges'))}} 
                </td>
            </tr>
            @endcan
            @can('view_sale.sale_price')

              <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Net Total')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('net_total'),2)}}
                </td>
            </tr>
            @endcan
            @can('view_sale.sale_paid')
              <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Total Paid')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('paid'),2)}}
                </td>
            </tr>
            @endcan
            @can('view_sale.sale_due')
               <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Total Due')}} :</b>
                </td>
                <td>
                    {{number_format($result->sum('due'),2)}}
                </td>
            </tr>
            @endcan
            @can('view_sale.qty')
            <tr style="background-color: #F8F9F9;border: 1px solid #ddd;">
                <td style="text-align: right;">
                    <b>{{_lang('Sale Qty')}} :</b>
                </td>
                <td>{{$total_quantity}}</td>
            </tr>
            @endcan

            
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