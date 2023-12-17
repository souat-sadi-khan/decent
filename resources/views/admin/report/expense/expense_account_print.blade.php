<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5>  {{ _lang('Expense Account Report') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>  {{ _lang('Expense Account Report') }}</b></h4>
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
                    <th scope="col">{{ _lang('Transection Sub Type') }}</th>
                    <th scope="col">{{ _lang('Date') }}</th>
                    <th scope="col">{{ _lang('Account By') }}</th>
                    @can('view_account.credit')
                    @if ($transaction_type=='All' || $transaction_type=='Credit')
                    <th scope="col">{{ _lang('Credit') }}</th>
                    @endif
                    @endcan

                    @can('view_account.debit')
                    @if ($transaction_type=='All' || $transaction_type=='Debit')
                    <th scope="col">{{ _lang('Debit') }}</th>
                    @endif
                    @endcan
                   
                </tr>
            </thead>
                     <tbody>
                @foreach ($result as $element)
                <tr>
                    <td>{{ $element->sub_type }}</td>
                    <td>
                        {{ formatDate($element->date) }}
                    </td>
                    <td>
                        {{ $element->user->email }}
                        
                    </td>
                   @can('view_account.credit')
                   @if ($transaction_type=='All' || $transaction_type=='Credit')
                       <td>
                           @if ($element->type=='Credit')
                              {{ number_format($element->amount,2) }}
                           @endif
                       </td>
                   @endif
                   @endcan

                   @can('view_account.debit')
                   @if ($transaction_type=='All' || $transaction_type=='Debit')
                       <td>
                            @if ($element->type=='Debit')
                              {{ number_format($element->amount,2) }}
                           @endif
                       </td>
                   @endif
                   @endcan
                  
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">{{ _lang('Total') }}</th>
                    @can('view_account.credit')
                    @if ($transaction_type=='All' || $transaction_type=='Credit')
                    <td>{{ number_format($result->where('type','Credit')->sum('amount'),2) }}</td>
                    @endif
                    @endcan
                    @can('view_account.debit')
                    @if ($transaction_type=='All' || $transaction_type=='Debit')
                    <td>{{ number_format($result->where('type','Debit')->sum('amount'),2) }}</td>
                    @endif
                    @endcan
                </tr>
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