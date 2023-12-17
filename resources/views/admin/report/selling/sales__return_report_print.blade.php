<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5>  {{ _lang('Sale Return Report') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
        
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
        class="bg-success text-light">
        <b>  {{ _lang('Sale Return Report') }}</b></h4>
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
                            <th>{{ _lang('Return Ref') }}</th>
                            <th>{{ _lang('Client') }}</th>
                            <th>{{ _lang('Date') }}</th>
                            <th>{{ _lang('Discount') }}</th>
                            <th>{{ _lang('Net Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $return)
                        <tr>
                            <td style="width: 20%">{{ $return->reference_no }}</td>
                            <td style="width: 15%">{{ $return->client?$return->client->name:'' }}</td>
                            <td style="width: 20%">{{ $return->date }}</td>
                            <td style="width: 20%">{{ number_format($return->discount_amount,2) }}</td>
                            <td style="width: 25%">{{ number_format($return->net_total,2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">{{ _lang('Total') }}</td>
                            <td>{{ number_format($result->sum('discount_amount'),2) }}</td>
                            <td>{{ number_format($result->sum('net_total'),2) }}</td>
                        </tr>
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