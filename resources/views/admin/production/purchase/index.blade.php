@extends('layouts.app', ['title' => _lang('Production Purchases'), 'modal' => 'lg'])
@push('admin.css')
<style>
 table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
    padding: 0.2rem 0.5rem;
}
</style>
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Purchases for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production Purchases')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('purchase') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">
                {{-- Old Link --}}
{{--             @can('purchase.create')
            <a data-placement="bottom" title="Create New Production Product" type="button" class="btn btn-info" href ="{{ route('admin.production-purchase.request') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('New Purchase')}}</a>
            @endcan --}}
             @can('purchase.create')
            <a data-placement="bottom" title="Create New Production Product" type="button" class="btn btn-info" href ="{{ route('admin.new_purchase') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('New Purchase')}}</a>
            @endcan
            </h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('employee_id',  _lang('Purchase For') . ':') !!}
                                {!! Form::select('employee_id', $employeis, null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                           <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('client_id',  _lang('Supplier') . ':') !!}
                                {!! Form::select('client_id', $clients, null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('status',  _lang('Purchase Status') . ':') !!}
                                {!! Form::select('status', ['Received'=>'Received','Pending'=>'Pending','Ordered'=>'Ordered'], null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('payment_status',  _lang('Payment Status') . ':') !!}
                                {!! Form::select('payment_status', ['Paid' => _lang('Paid'), 'Due' => _lang('Due'), 'Partial' => _lang('Partial')], null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.purchase.datatable') }}">
                    <thead>
                        <tr>
                            <th>{{_lang('SL')}}</th>
                            <th>{{_lang('Purchase By')}}</th>
                            <th>{{_lang('Supplier')}}</th>
                            <th>{{_lang('Reference No')}}</th>
                            <th>{{_lang('Purchase Date')}}</th>
                            <th>{{_lang('Grand Total')}}</th>
                            <th>{{_lang('Purchase Status')}}</th>
                            <th>{{_lang('Payment Status')}}</th>
                            <th>{{_lang('action')}}</th>
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
<script src="{{ asset('js/production/purchase.js') }}"></script>
<script>
     @if(session('msg'))
      toastr.error('{{ session('msg') }}')
     @endif
</script>
@endpush