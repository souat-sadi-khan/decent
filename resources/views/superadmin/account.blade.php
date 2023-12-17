@extends('layouts.app', ['title' => _lang('Account Cashflow'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/picker/daterangepicker.css')}}">
@endpush
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Account Cashflow."><i class="fa fa-universal-access mr-4"></i> {{_lang('Account Cashflow')}}</h1>
    <p>{{_lang(' Account Cashflow.')}}</p>
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
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('account_id', _lang('Account') . ':') !!}
                  {!! Form::select('account_id', $accounts, null, ['class' => 'form-control select']); !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('transaction_date_range', _lang('Date Range') . ':') !!}
                  {!! Form::text('date_range', null, ['placeholder' => _lang('Date Range'), 'class' => 'form-control', 'id' => 'transaction_date_range', 'readonly']); !!}
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  {!! Form::label('transaction_type', _lang('Transection Type') . ':') !!}
                  <div class="input-group">
                    {!! Form::select('transaction_type', ['' => _lang('All'),'Debit' => _lang('Debit'), 'Credit' => _lang('Credit')], '', ['class' => 'form-control select']) !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('super_admin.account') }}">
          <thead>
            <th>{{ _lang('Date') }}</th>
            <th>{{ _lang('Account') }}</th>
            <th>{{ _lang('Description') }}</th>
            <th>{{ _lang('Credit') }}</th>
            <th>{{ _lang('Debit') }}</th>
            <th>{{ _lang('Balance') }}</th>
            <th>{{ _lang('Hidden') }}</th>
  
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
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
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
{{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/picker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/js/picker/moment-timezone-with-data.min.js') }}"></script>
<script>
$('.select').select2();
$(document).ready(function() {
    $('#transaction_date_range').daterangepicker({
        autoUpdateInput: false,
    });
    $("#transaction_date_range").on('apply.daterangepicker', function(start, end) {
        var start = '';
        var end = '';
        if ($('#transaction_date_range').val()) {
            start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
        emran.ajax.reload();

    })
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        responsive: true,
        columnDefs: [{
            orderable: false,
            width: 100,
            targets: [5]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
            }
        }
    });
    // Account Book
    emran = $('.content_managment_table').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        "ajax": {
            "url": $('.content_managment_table').data('url'),
            "data": function(d) {
                var start = '';
                var end = '';
                if ($('#transaction_date_range').val() != '') {
                    start = $('#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end = $('#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }

                d.account_id = $('#account_id').val();
                d.type = $('#transaction_type').val();
                d.start_date = start,
                    d.end_date = end
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [5]
        }],

        order: [0, 'asc'],
        "searching": false,
        columns: [{
            data: 'operation_date',
            name: 'operation_date'
        }, {
            data: 'account_name',
            name: 'account_name'
        }, {
            data: 'sub_type',
            name: 'sub_type'
        }, {
            data: 'credit',
            name: 'amount'
        }, {
            data: 'debit',
            name: 'amount'
        }, {
            data: 'balance',
            name: 'balance'
        },{
            data: 'hidden',
            name: 'hidden'
        }, ],
    });
});

$('#transaction_type, #account_id').change(function() {
    emran.ajax.reload();
});
</script>
@endpush