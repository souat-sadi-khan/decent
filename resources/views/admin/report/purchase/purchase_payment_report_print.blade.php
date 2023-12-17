<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5>  {{ _lang('Purchase Payment Report') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>  {{ _lang('Purchase Payment Report') }}</b></h4>
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
                    <th scope="col" style="width: 15%">{{ _lang('Ref No') }}</th>
                    <th scope="col" style="width: 15%">{{ _lang('Employee') }}</th>
                    <th scope="col" style="width: 70%">{{ _lang('Payment') }}</th>
                </tr>
            </thead>
       <tbody>
   <tbody>

                @foreach ($result as $element)
                <tr>
                    <th>{{ $element->transaction->reference_no }}
                        @can('view_purchase.price')
                     <br>{{ _lang('Total Amt') }} ({{ $element->transaction->net_total }}) 
                     @endcan
                    </th>
                    <td>{{ $element->employee?$element->employee->name:'' }} </td>
                 @php
                    $payments =App\models\Production\TransactionPayment::where('transaction_id',$element->transaction_id)->whereBetween('payment_date',[$sDate,$eDate])->get();
                @endphp
                <td>
                    <table class="table">
                     <tbody>
                    @foreach ($payments as $payment)
                         <tr>
                             <td style="width: 30%">{{ $payment->payment_date }}</td>
                             <td style="width: 30%">{{ $payment->method }}</td>
                             @can('view_purchase.paid')
                             <td style="width: 40%">{{ $payment->amount }}</td>
                             @endcan
                         </tr>
                    @endforeach
                    @can('view_purchase.paid')
                     <tr>
                         <td colspan="2">{{ _lang('Total Payment') }}</td>
                         <td>{{ $payments->sum('amount') }}</td>
                     </tr>
                     @endcan
                     </tbody>
                    </table>
                </td>
                </tr>

               
                @endforeach
            </tbody>
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