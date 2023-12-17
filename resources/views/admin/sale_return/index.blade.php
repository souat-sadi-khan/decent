@extends('layouts.app', ['title' => _lang('Sale Return List'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title=""><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Sale Return List')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="tile">
    <div class="tile-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.sale.return.index') }}">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Reference')</th>
                                        <th>@lang('Parent Sale')</th>
                                        <th>@lang('Customer')</th>
                                        <th>@lang('Payment Status')</th>
                                        <th>@lang('Total')</th>
                                        <th>@lang('Due') </th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <tr class="bg-gray font-17 text-center footer-total">
                                    <td colspan="4"><strong>@lang('Total'):</strong></td>
                                    <td id="footer_payment_status_count"></td>
                                    <td><span class="display_currency" id="footer_purchase_return_total" data-currency_symbol ="true"></span></td>
                                    <td><span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span></td>
                                    <td></td>
                                </tr>
                                </tfoot>
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
<script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script>
$('.select').select2();
    $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });
  purchase_return_table = $('.content_managment_table').DataTable({
      responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-clipboard" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-table" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
            ],

            columnDefs: [{
                width: "80px",
                targets: [0]
            }, {
                orderable: false,
                targets: [6,7]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: $('.content_managment_table').data('url'),
          
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
            "fnDrawCallback": function (oSettings) {
                var total_purchase = sum_table_col($('.content_managment_table'), 'net_total');
                $('#footer_purchase_return_total').text(total_purchase);
                
                $('#footer_payment_status_count').html(__sum_status_html($('.content_managment_table'), 'payment-status-label'));

                var total_due = sum_table_col($('.content_managment_table'), 'payment_due');
                $('#footer_total_due').text(total_due);
                
            },
             createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(4)').attr('class', 'clickable_td');
            }
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
                    $('#ref_no').focus();
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
</script>
@endpush