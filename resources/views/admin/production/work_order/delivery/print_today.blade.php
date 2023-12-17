<div id="print_table_today" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5> Work Order ( {{ $work_order->prefix }} {{ $work_order->code}} ) Delivery Invoice </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b> Work Order ( {{ $work_order->prefix }} {{ $work_order->code}} ) Delivery Invoice</b></h4>
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
    <div class="col-md-12 table-responsive">
        @php
            $from = get_option('default_brand');
            $from = App\models\Production\Brand::where('id', $from)->firstorFail();
            $to = $work_order->brand_id;
            $to = App\models\Production\Brand::where('id', $to)->firstorFail();
        @endphp
        <table class="table table-sm">
            <tr>
                <th>From</th>
                <th class="text-right">To</th>
            </tr>
            <tr>
                <td>{{ $from->name }}</td>
                <td class="text-right">{{ $to->name }}</td>
            </tr>
            <tr>
                <td>{{ $from->owner_name }}</td>
                <td class="text-right">{{ $to->owner_name }}</td>
            </tr>
            <tr>
                <td>{{ $from->phone }}</td>
                <td class="text-right">{{ $to->phone }}</td>
            </tr>
            <tr>
                <td>{{ $from->email }}</td>
                <td class="text-right">{{ $to->email }}</td>
            </tr>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-sm table-bordered content_managment_table">
            <thead class="table-info">
                <tr>
                    <th width="70%" class="text-center">Product</th>
                    <th width="30%" class="text-center">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $work_order_delivery_id = $work_order_delivery->id;
                    $work_order_delivery_items = App\models\Production\WorkOrderDeliveryItem::where('work_order_deliveries_id', $work_order_delivery_id)->where('date', $date)->get();
                @endphp
                @foreach ($work_order_delivery_items as $work_order_delivery_item)
                    @php
                        $total += $work_order_delivery_item->quantity;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $work_order_delivery_item->product->name }} ({{ $work_order_delivery_item->variation->name }})</td>
                        <td class="text-right">{{ get_option('currency') }} {{ number_format($work_order_delivery_item->quantity, 2)}} </td>
                    </tr>
               @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right">Total</td>
                    <td class="text-right">{{ number_format($total, 2)}} </td>
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
    $print_table = 'print_table_today';

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