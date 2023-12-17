@extends('layouts.app', ['title' => _lang('Customer Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Customer Report')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                  <div class="table-responsive">
        <table class="table table-bordered table-striped" id="Customer">
            <thead>
                <tr>
                    <th>{{ _lang('Client') }}</th>
                    <th>{{ _lang('Total Purchase') }}</th>
                    <th>{{ _lang('Purchase Return') }}</th>
                    <th>{{ _lang('Total Sale') }}</th>
                    <th>{{ _lang('Sale Return') }}</th>
                    <th>{{ _lang('Opening Balance Due') }}</th>
                    <th>{{ _lang('Due') }}</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bg-gray footer-total" style="font-size: 16px">
                    <td><strong>{{ _lang('Total') }}:</strong></td>
                    <td><span class="display_currency" id="footer_total_purchase" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_purchase_return" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_sell" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_sell_return" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_opening_bal_due" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span></td>
                </tr>
            </tfoot>
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
<script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script>
    $('.select').select2();
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
       supplier_report_tbl = $('#Customer').DataTable({
        processing: true,
        serverSide: true,
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
        ajax: '/admin/report/customer',
        columnDefs: [
            { targets: [5], orderable: false, searchable: false },
            { targets: [1, 2, 3, 4], searchable: false },
        ],
   columns: [
            { data: 'name', name: 'name' },
            { data: 'total_purchase', name: 'total_purchase' },
            { data: 'total_purchase_return', name: 'total_purchase_return' },
            { data: 'total_invoice', name: 'total_invoice' },
            { data: 'total_sell_return', name: 'total_sell_return' },
            { data: 'opening_balance_due', name: 'opening_balance_due' },
            { data: 'due', name: 'due' },
        ],
        fnDrawCallback: function(oSettings) {
            var total_purchase = sum_table_col($('#Customer'), 'total_purchase');
            $('#footer_total_purchase').text(total_purchase);

            var total_purchase_return = sum_table_col(
                $('#Customer'),
                'total_purchase_return'
            );
            $('#footer_total_purchase_return').text(total_purchase_return);

            var total_sell = sum_table_col($('#Customer'), 'total_invoice');
            $('#footer_total_sell').text(total_sell);

            var total_sell_return = sum_table_col($('#Customer'), 'total_sell_return');
            $('#footer_total_sell_return').text(total_sell_return);

            var total_opening_bal_due = sum_table_col(
                $('#Customer'),
                'opening_balance_due'
            );
            $('#footer_total_opening_bal_due').text(total_opening_bal_due);

            var total_due = sum_table_col($('#Customer'), 'total_due');
            $('#footer_total_due').text(total_due);

        },
    });

    function sum_table_col(table, class_name) {
    var sum = 0;
    table
        .find('tbody')
        .find('tr')
        .each(function() {
            if (
                parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                )
            ) {
                sum += parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                );
            }
        });

    return sum;
}
</script>

@endpush
