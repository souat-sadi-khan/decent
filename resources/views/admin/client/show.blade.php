@extends('layouts.app', ['title' => _lang('Client Details'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
    <style>
        .table th, .table td {
         padding: 0.2rem 0.5rem;
        }
    </style>
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Client."><i class="fa fa-universal-access mr-4"></i> {{_lang('Client Details')}}</h1>
        <p>{{_lang('Create Client. Here you can Add, Edit & Delete Client')}}</p>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-3 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <strong>{{ _lang('Customer Name') }}: {{ $contact->name }}</strong><br><br>
                                <strong><i class="fa fa-map-marker margin-r-5"></i>{{ _lang('Address') }}</strong>
                                <p class="text-muted">
                                    @if($contact->landmark)
                                    {{ $contact->landmark }}
                                    @endif
                                    {{ ', ' . $contact->city }}
                                    @if($contact->state)
                                    {{ ', ' . $contact->state }}
                                    @endif
                                    <br>
                                    @if($contact->country)
                                    {{ $contact->country }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <strong><i class="fa fa-mobile margin-r-5"></i>{{ _lang('Mobile') }}</strong>
                                <p class="text-muted">
                                    {{ $contact->mobile }}
                                </p>
                                @if($contact->landline)
                                <strong><i class="fa fa-phone margin-r-5"></i> {{ _lang('Landline') }}</strong>
                                <p class="text-muted">
                                    {{ $contact->landline }}
                                </p>
                                @endif
                                @if($contact->alternate_number)
                                <strong><i class="fa fa-phone margin-r-5"></i> {{ _lang('Alternet Number') }}</strong>
                                <p class="text-muted">
                                    {{ $contact->alternate_number }}
                                </p>
                                @endif
                                @if($contact->email)
                                <strong><i class="fa fa-envelope margin-r-5"></i> {{ _lang('Email') }}</strong>
                                <p class="text-muted">
                                    {{ $contact->email }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <strong>{{ _lang('Bank Name') }}: {{ $contact->bank_name }}</strong><br><br>
                                <strong><i class="fa fa-bandcamp margin-r-5"></i>{{ _lang('Account Name') }}</strong>
                                <p class="text-muted">
                                 {{ $contact->account_name }}
                                </p>

                                 <strong><i class="fa fa-bandcamp margin-r-5"></i>{{ _lang('Bank Holder') }}</strong>
                                 <p class="text-muted">
                                 {{ $contact->bank_holder }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <strong>{{ _lang('Total Sale') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->total_invoice }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>{{ _lang('Total Sale Paid') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->invoice_received }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>{{ _lang('Total Sale Due') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->total_invoice - $contact->invoice_received }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>@lang('Total Sale Return')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->sale_return }} {{ get_option('currency_symbol') }} </span>
                                </p>
                                <strong>@lang('Sale Return Paid')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->return_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>@lang('Sale Return Due')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->sale_return-$contact->return_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                @if(!empty($contact->opening_balance) && $contact->opening_balance != '0.00')
                                <strong>{{ _lang('Opening Balance') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->opening_balance }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>{{ _lang('Opening Balance Due') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->opening_balance - $contact->opening_balance_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                @endif
                                @php
                                $opening =$contact->opening_balance - $contact->opening_balance_paid;
                                $sale =$contact->total_invoice -$contact->invoice_received;
                                $return =$contact->sale_return -$contact->return_paid;
                                $balance =$opening+$sale-$return;
                                @endphp
                                <strong>{{ _lang('Available Balance')}}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $balance}} {{ get_option('currency_symbol') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sale related Transaction</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped ajax_view" id="sell_table">
                            <thead>
                                <tr>
                                    <th>{{_lang('Date')}}</th>
                                    <th>{{_lang('Ref')}}</th>
                                    <th>{{_lang('Client')}}</th>
                                    <th>{{_lang('Payment Status')}}</th>
                                    <th>{{_lang('Total Amount')}}</th>
                                    <th>{{_lang('Total Paid')}}</th>
                                    <th>{{_lang('Due')}}</th>
                                    <th>{{_lang('action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sale Return  related Transaction</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="purchase_return_datatable">
                            <thead>
                                <tr>
                                    <th>{{ _lang('Date') }}</th>
                                    <th>{{ _lang('Reference') }}</th>
                                    <th>{{ _lang('Parent Sale') }}</th>
                                    <th>{{ _lang('Customer') }}</th>
                                    <th>{{ _lang('Payment Status') }}</th>
                                    <th>{{ _lang('Total') }}</th>
                                    <th>{{ _lang('Due') }} </th>
                                    <th>{{ _lang('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Related</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped ajax_view" id="ob_payment_table">
                            <thead>
                                <tr>
                                    <th>{{ _lang('Date') }}</th>
                                    <th>{{ _lang('Amount') }}</th>
                                    <th>{{ _lang('Payment Method') }}</th>
                                    <th>{{ _lang('T.Type') }}</th>
                                    <th>{{ _lang('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic initialization -->
    @stop
    {{-- Script Section --}}
    @push('scripts')
    <script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    {{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script>
    $('.select').select2();
    $(document).on('click', '#content_managment', function(e) {
    e.preventDefault();
    //open modal
    $('#modal_remote').modal('toggle');
    // it will get action url
    var url = $(this).data('url');
    // leave it blank before ajax call
    $('.modal-body').html('');
    // load ajax loader
    $('#modal-loader').show();
    $.ajax({
    url: url,
    type: 'Get',
    dataType: 'html'
    })
    .done(function(data) {
    $('.modal-body').html(data).fadeIn(); // load response
    $('#modal-loader').hide();
    $('#branch_no').focus();
    $('.select').select2();
    _modalClassFormValidation();
    _modalFormValidation();
    })
    .fail(function(data) {
    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
    $('#modal-loader').hide();
    });
    });
    function myFunction(url) {
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=1400,height=400");
    }
    var sell_table = $('#sell_table').DataTable({
    responsive: {
    details: {
    type: 'column',
    target: 'tr'
    }
    },
    processing: true,
    serverSide: true,
    aaSorting: [[0, 'desc']],
    ajax: '{{ route('admin.sale.pos.index',['customer_id'=>$contact->id]) }}',
    columnDefs: [ {
    "targets": 7,
    "orderable": false,
    "searchable": false
    } ],
    columns: [
    // { data: 'checkbox', name: 'checkbox' },
    {
    data: 'date',
    name: 'date'
    }, {
    data: 'reference_no',
    name: 'reference_no'
    }, {
    data: 'client',
    name: 'client'
    }, {
    data: 'payment_status',
    name: 'payment_status'
    }, {
    data: 'net_total',
    name: 'net_total'
    }, {
    data: 'paid',
    name: 'paid'
    }, {
    data: 'due',
    name: 'due'
    }, {
    data: 'action',
    name: 'action'
    }
    ]
    });

     purchase_return_table = $('#purchase_return_datatable').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        ajax: {
            url: '/admin/sale/return?client_id={{ $contact->id }}',
          
        },
        columnDefs: [ {
            "targets": [7],
            "orderable": false,
            "searchable": false
        } ],
          columns: [
                { data: 'date', name: 'date'  },
                { data: 'reference_no', name: 'reference_no'},
                { data: 'parent_sale', name: 'parent_sale'},
                { data: 'client', name: 'client'},
                { data: 'payment_status', name: 'payment_status'},
                { data: 'net_total', name: 'net_total'},
                { data: 'payment_due', name: 'payment_due'},
                { data: 'action', name: 'action'}
            ],
    });

         //Opening balance payment
    ob_payment_table = $('#ob_payment_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        ajax: '/admin/client/payment-list/{{ $contact->id }}',
        columns: [
            { data: 'payment_date', name: 'payment_date'  },
            { data: 'amount', name: 'transaction_payments.amount'  },
            { data: 'method', name: 'method' },
            { data: 'transaction_type', name: 'transaction_type' },
            { data: 'action', "orderable": false, "searchable": false },
        ]
    });
  $(document).on('click','#btn_modal',function(){
    var url =$(this).data('url');
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=1400,height=400")
  })
    </script>
    @endpush