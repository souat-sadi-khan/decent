<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5> {{ $employee }} {{ $head }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b> {{$employee }} {{ $head }}</b></h4>
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
        <h3 class="text-center">Date of Transaction : {{ formatDate($model->date_of_transaction) }} </h3>
        <table class="table table-hover table-sm table-bordered content_managment_table">
            <thead class="table-info">
                <tr>
                    <th class="text-center">Payment Method</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $model->payment_method }}</td>
                    <td class="text-right">{{ get_option('currency') }} {{ number_format($model->amount, 2)}} </td>
                </tr>
            </tbody>
            <tfoot>
                @if ($model->payment_method == 'Mobile Banking')
                    <tr>
                        <td class="text-center">Mobile Banking Name</td>
                        <td class="text-right">{{ $model->mob_banking_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Account Holder Name</td>
                        <td class="text-right">{{ $model->mob_account_holder }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Sending Mobile Number</td>
                        <td class="text-right">{{ $model->sending_mob_no }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Receiving Mobile Number</td>
                        <td class="text-right">{{ $model->receiving_mob_no }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Transaction Number</td>
                        <td class="text-right">{{ $model->mob_tx_id }}</td>
                    </tr>
                @elseif ($model->payment_method == 'Bank Check') 
                    <tr>
                        <td class="text-center">Bank Name</td>
                        <td class="text-right">{{ $model->bank_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Account Holder Name</td>
                        <td class="text-right">{{ $model->account_holder }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Account Number</td>
                        <td class="text-right">{{ $model->account_no }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Check Number</td>
                        <td class="text-right">{{ $model->check_no }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Check Active Date</td>
                        <td class="text-right">{{ formatDate($model->check_active_date) }}</td>
                    </tr>
                @endif
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