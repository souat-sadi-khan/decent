<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5> {{ $employee }} Report </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b> {{$employee }}  Report</b></h4>
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
            <thead class="table-info">
                <tr>
                    @if ($employee == 'All Employee')
                        <th width="15%" class="text-center">Employee</th>
                    @endif
                    <th width="15%" class="text-center">Head</th>
                    <th width="15%" class="text-center">Date</th>
                    <th width="25%" class="text-center">Payment Method</th>
                    <th width="25%" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($models as $model)
                    @php
                        $total += $model->amount;
                    @endphp
                    <tr>
                        @if ($employee == 'All Employee')
                            <td class="text-center">{{ $model->employee->name }} </td>
                        @endif
                        <td class="text-center">{{ $model->head }} </td>
                        <td class="text-center">{{ formatDate($model->date_of_transaction) }}</td>
                        <td class="text-center">{{ $model->payment_method }}</td>
                        <td class="text-right">{{ get_option('currency') }} {{ number_format($model->amount, 2)}} </td>
                    </tr>
               @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="{{ $employee == 'All Employee' ? '4' : '3' }}">Total</td>
                    <td class="text-right">{{ get_option('currency') }} {{ number_format($total, 2)}} </td>
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