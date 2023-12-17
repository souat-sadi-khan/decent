<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5> Ecommerce  {{ $status == 'all' ? 'All Status' : toWord($status) }} Report </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b> {{ $status == 'all' ? 'All Status' : toWord($status) }} Report</b></h4>
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
        <h4 class="text-center">{{ formatDate($start_date) }} - {{ formatDate($end_date) }}</h4>
        <table class="table table-hover table-sm table-bordered content_managment_table">
            <thead>
                <tr>
                    @if($status == 'all') 
                        <th class="text-center">{{_lang('Status')}}</th>
                    @endif
                    <th class="text-center">{{_lang('Date')}}</th>
                    <th class="text-center">{{_lang('Payment Status')}}</th>
                    <th class="text-center">{{_lang('Tracker')}}</th>
                    <th class="text-right">{{_lang('Subtotal')}}</th>
                    <th class="text-right">{{_lang('Shipping')}}</th>
                    <th class="text-right">{{_lang('Total')}}</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                @if (count($models))
                    @foreach ($models as $model)
                        <tr>
                            @if($status == 'all')
                                <td class="text-center">
                                    @if ($model->ecommerce_status == 'pending')
                                        {{_lang('Pending')}}
                                    @elseif( $model->ecommerce_status == 'confirm')
                                        {{_lang('Confirm')}}
                                    @elseif( $model->ecommerce_status == 'progressing')
                                        {{_lang('In Progressing')}}
                                    @elseif( $model->ecommerce_status == 'shipment')
                                        {{_lang('In Shipment')}}
                                    @elseif( $model->ecommerce_status == 'success')
                                        {{_lang('Success')}}
                                    @elseif( $model->ecommerce_status == 'return')
                                        {{_lang('Return')}}
                                    @elseif( $model->ecommerce_status == 'payment_done')
                                        {{_lang('Payment Done')}}
                                    @else 
                                        {{_lang('Cancel')}}
                                    @endif
                                </td>
                            @endif
                            <td class="text-center">{{formatDate($model->created_at)}}</td>
                            <td class="text-center">
                                <span class="{{ $model->payment_status == 'Paid' ? 'text-success' : 'text-danger' }}">{{ $model->payment_status == 'Paid' ? 'Paid' : 'Due' }}</span>
                            </td>
                            <td class="text-center">{{$model->reference_no}}</td>
                            <td class="text-right">{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{ number_format($model->sub_total, 2)}}</td>
                            <td class="text-right">{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{number_format($model->shipping_charges, 2)}}</td>
                            <td class="text-right">{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{number_format($model->net_total, 2)}}</td>
                           
                            
                        </tr>
                    @endforeach
                @else 
                    <tr>
                        <td class="text-center" colspan="{{ $status == 'all' ? 7 : 6}}">No Data Found</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="{{ $status == 'all' ? 4 : 3 }}"></td>
                    <td class="text-right">
                        {{get_option('currency') ? get_option('currency') : 'BDT'}} {{ number_format($models->sum('sub_total'), 2) }}
                    </td>
                    <td class="text-right">
                        {{get_option('currency') ? get_option('currency') : 'BDT'}} {{ number_format($models->sum('shipping_charges'), 2) }}
                    </td>
                    <td class="text-right">
                        {{get_option('currency') ? get_option('currency') : 'BDT'}} {{( number_format($models->sum('net_total'), 2) )}}
                    </td>
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