@extends('layouts.app', ['title' => _lang('Product Stock'), 'modal' => 'lg'])
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
        <h1 data-placement="bottom" title=""><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Product Stock')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="card">
           <div class="tile">
                <h3 class="tile-title">
                        <a data-placement="bottom" title="Create New Ecommerce Product" type="button" class="btn btn-info" href ="{{ route('admin.product_stock.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('Retail Stock')}}</a>
                    
                    <a data-placement="bottom" title="" type="button" class="btn float-right btn-info" href ="{{ route('admin.whole_stock') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('Wholesale Stock')}}</a>

                </h3>
                <div class="card-body">
                    <div class="row">
                         <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('brand_id', _lang('Brand').':') !!}
                                {!! Form::select('brand_id', $brands, null, ['placeholder' =>
                                _lang('All'),'class' => 'form-control select']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('category_id', _lang('Category').':') !!}
                                {!! Form::select('category_id', $categories, null, ['class' => 'form-control select','placeholder' =>
                                _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('term',_lang('Search Key').':') !!}
                              {{ Form::text('term', null, ['class' => 'form-control', 'id'=>'term', 'placeholder' => _lang('Search Key'),'required'=>'']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="tile">
    <div class="tile-body">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered content_managment_table" data-url="{{ route('admin.product_stock.index') }}">
                    <thead>
                        <tr>
                            <th>{{ _lang('Name') }}</th>
                            <th>{{ _lang('Sku') }}</th>
                            <th>{{ _lang('Retail Qty') }}</th>
                            <th>{{ _lang('Wholesale Qty') }}</th>
                            <th>{{ _lang('Retail Price') }}</th>
                            <th>{{ _lang('Wholesale Price') }}</th>
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
                targets: [5]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,
            ajax: { 
            url: $('.content_managment_table').data('url'),
            data: function(d) {
                d.brand_id = $('select#brand_id').val();
                d.category_id = $('select#category_id').val();
                d.term = $('input#term').val();
            },
          },
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'product_name',
                    name: 'product_name'
                }, {
                    data: 'f_sku',
                    name: 'f_sku'
                }, {
                    data: 'retail_qty',
                    name: 'retail_qty'
                }, {
                    data: 'f_qty',
                    name: 'f_qty'
                }, {
                    data: 'retail_sell_price',
                    name: 'retail_sell_price'
                },{
                    data: 'selling_price',
                    name: 'selling_price'
                }
            ]

        });


      $('select#brand_id, select#category_id').on(
        'change',
        function() {
            emran.ajax.reload();
        }
    );
      $('input#term').on('blur',function(){
          emran.ajax.reload();
      })

</script>
@endpush