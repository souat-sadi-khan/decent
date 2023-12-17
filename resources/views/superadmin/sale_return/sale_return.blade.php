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
                <table class="table table-bordered content_managment_table" data-url="{{ route('super_admin.sell_return') }}">
                    <thead>
                        <tr>
                            <th>{{ _lang('Date') }}</th>
                            <th>{{ _lang('Parent Sale') }}</th>
                            <th>{{ _lang('Client') }}</th>
                            <th>{{ _lang('Sale Amt') }}</th>
                            <th>{{ _lang('Return Amt') }}</th>
                            <th>{{ _lang('Count') }}</th>
                            <th>{{ _lang('Hide') }}</th>
                            <th>{{ _lang('Hidden') }}</th>
                        </tr>
                    </thead>
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
              // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                orderable: false,
                width: 100,
                targets: [7]
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

       var emran= $('.content_managment_table').DataTable({
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
                targets: [7]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,
            ajax: $('.content_managment_table').data('url'),
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
               {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'reference_no',
                    name: 'reference_no'
                }, {
                    data: 'client',
                    name: 'client'
                }, {
                    data: 'sale',
                    name: 'sale'
                }, {
                    data: 'return',
                    name: 'return'
                }, {
                    data: 'count',
                    name: 'count'
                },{
                    data: 'hide',
                    name: 'hide'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });

</script>
@endpush