@extends('layouts.app', ['title' => _lang('Supplier Details'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
    <style>
.table th, .table td {
   padding: 0.2rem 0.5rem;
}
 table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
    padding: 0.2rem 0.5rem;
}
    </style>
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Supplier."><i class="fa fa-universal-access mr-4"></i> {{_lang('Supplier Details')}}</h1>
        <p>{{_lang('Create Supplier. Here you can Add, Edit & Delete Supplier')}}</p>
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
                                <strong>{{ _lang('Supplier Name') }}: {{ $contact->name }}</strong><br><br>
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
                                <strong>{{ _lang('Total Purchase') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->total_purchase }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>{{ _lang('Total Purchase Paid') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->purchase_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>{{ _lang('Total Purchase Due') }}</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->total_purchase - $contact->purchase_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>@lang('Total Purchase Return')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->purchase_return }} {{ get_option('currency_symbol') }} </span>
                                </p>
                                <strong>@lang('Purchase Return Paid')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->return_paid }} {{ get_option('currency_symbol') }}</span>
                                </p>
                                <strong>@lang('Purchase Return Due')</strong>
                                <p class="text-muted">
                                    <span class="display_currency" data-currency_symbol="true">
                                    {{ $contact->purchase_return-$contact->return_paid }} {{ get_option('currency_symbol') }}</span>
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
                                $purchase =$contact->total_purchase -$contact->purchase_paid;
                                $return =$contact->purchase_return -$contact->return_paid;
                                $balance =$opening+$purchase-$return;
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
                        <h3 class="card-title">Purchase related Transaction</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped ajax_view" id="purchase_table">
                            <thead>
                                <tr>
                                    <th>{{_lang('SL')}}</th>
                                    <th>{{_lang('Purchase By')}}</th>
                                    <th>{{_lang('Company')}}</th>
                                    <th>{{_lang('Reference No')}}</th>
                                    <th>{{_lang('Invoice No')}}</th>
                                    <th>{{_lang('Purchase Date')}}</th>
                                    <th>{{_lang('Grand Total')}}</th>
                                    <th>{{_lang('Purchase Status')}}</th>
                                    <th>{{_lang('Payment Status')}}</th>
                                    <th>{{_lang('action')}}</th>
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
    var purchase=$('#purchase_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary glyphicon glyphicon-duplicate'
            }, {
                extend: 'csv',
                className: 'btn btn-primary glyphicon glyphicon-save-file'
            }, {
                extend: 'excel',
                className: 'btn btn-primary glyphicon glyphicon-list-alt'
            }, {
                extend: 'pdf',
                className: 'btn btn-primary glyphicon glyphicon-file'
            }, {
                extend: 'print',
                className: 'btn btn-primary glyphicon glyphicon-print'
            }],
            columnDefs: [{
                orderable: false,
                targets: [8]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,

             ajax: '{{ route('admin.purchase.datatable',['client_id'=>$contact->id]) }}',
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'purchase_by',
                    name: 'purchase_by'
                }, {
                    data: 'brand_id',
                    name: 'brand_id'
                }, {
                    data: 'reference_no',
                    name: 'reference_no'
                }, {
                    data: 'invoice_no',
                    name: 'invoice_no'
                }, {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'total',
                    name: 'total'
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'payment_status',
                    name: 'payment_status'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

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