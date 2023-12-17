@extends('layouts.app', ['title' => _lang('Payment Account'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
<link rel="stylesheet" href="{{asset('backend/css/picker/daterangepicker.css')}}">
@endpush
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Payment Account."><i class="fa fa-universal-access mr-4"></i> {{_lang('Payment Account')}}</h1>
    <p>{{_lang(' Payment Account.')}}</p>
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
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('account_id', _lang('Account') . ':') !!}
                  {!! Form::select('account_id', $accounts, null, ['class' => 'form-control select']); !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('date_filter', _lang('Date Range') . ':') !!}
                  {!! Form::text('date_range', null, ['placeholder' => _lang('Date Range'), 'class' => 'form-control', 'id' => 'date_filter', 'readonly']); !!}
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.accounting.payment_account') }}">
          <thead>
            <tr>
              <td>{{ _lang('Date') }}</td>
              <th>{{_lang('Reference No')}}</th>
              <th>{{_lang('Payment Type')}}</th>
              <th>{{_lang('Account')}}</th>
              <th>{{_lang('Action')}}</th>
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
      _componentSelect2Normal();
if ($('#date_filter').length == 1) {
    $('#date_filter').daterangepicker({
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: moment().local().subtract(2, 'years'),
                maxDate: moment().local(),
                dateLimit: {
                    days: 90
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                drops: 'down',
                applyClass: 'btn-sm bg-slate',
                cancelClass: 'btn-sm btn-light'
        });
    $('#date_filter').on('apply.daterangepicker', function(ev, picker) {
        var start = '';
        var end = '';
        if ($('#transaction_date_range').val()) {
            start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
        emran.ajax.reload();
    });

    $('#date_filter').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        emran.ajax.reload();
    });
}

$('.select').select2();
$.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    responsive: true,
    columnDefs: [{
        orderable: false,
        width: 100,
        targets: [4]
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
var emran = $('.content_managment_table').DataTable({
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
            d.account_id = $('#account_id').val();
            var start_date = '';
            var endDate = '';
            if ($('#date_filter').val()) {
                var start_date = $('#date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
            d.start_date = start_date;
            d.end_date = endDate;
        }
    },
    columnDefs: [{
        "targets": 4,
        "orderable": false,
        "searchable": false
    }],
    columns: [{
        data: 'payment_date',
        name: 'payment_date'
    }, {
        data: 'transaction_number',
        name: 'transaction_number'
    }, {
        data: 'type',
        name: 'T.type'
    }, {
        data: 'account',
        name: 'account'
    }, {
        data: 'action',
        name: 'action'
    }],
});
$('select#account_id, #date_filter').change(function() {
    emran.ajax.reload();
});

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
            _componentSelect2Normal();
            _modalFormValidation();
        })
        .fail(function(data) {
            $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
            $('#modal-loader').hide();
        });
});

$('select#account_id, #date_filter').change(function() {
    emran.ajax.reload();
});
</script>
@endpush