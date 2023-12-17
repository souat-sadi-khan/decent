<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5>  {{ _lang('Product Report') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>  {{ _lang('Product Report') }}</b></h4>
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
             <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ _lang('Product') }}</th>
                    <th scope="col">{{ _lang('Variation') }}</th>
                    @can('view_product.cost_price')
                    <th scope="col">{{ _lang('Cost Price') }}</th>
                    @endcan
                    @can('view_product.sale_price')
                    <th scope="col">{{ _lang('Sale Price') }}</th>
                    @endcan
                    @can('view_product.qty')
                    <th scope="col">{{ _lang('Sale Qty') }}</th>
                    <th scope="col">{{ _lang('Return Qty') }}</th>
                    <th scope="col">{{ _lang('Stock') }}</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $element)
                  <tr>
                      <td>{{ $element->pro_name }}</td>
                      <td>{{ $element->variation }}</td>
                      @can('view_product.cost_price')
                      <td>{{ $element->default_purchase_price }}</td>
                      @endcan
                      @can('view_product.sale_price')
                      <td>{{ $element->selling_price }}</td>
                      @endcan
                      @can('view_product.qty')
                      <td>
                          @php
                              $sale =App\models\inventory\TransactionSellLine::where('product_id',$element->product_id)->where('variation_id',$element->variation_id)->get();
                          @endphp
                          {{ $sale->sum('quantity') }}
                      </td>
                      <td>{{ $sale->sum('quantity_returned') }}</td>
                      <td>{{ $element->qty }}</td>
                      @endcan
                  </tr>
                @endforeach
            </tbody>
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