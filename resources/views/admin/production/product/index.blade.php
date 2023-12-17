@extends('layouts.app', ['title' => _lang('Production Product'), 'modal' => 'xl'])
@push('admin.css')
<style>
.table th, .table td {
padding: 0.2rem 0.5rem;
}
</style>
@endpush
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production Product')}}</h1>
            <p>{{_lang('Create brand for Production. Here you can Add, Edit & Delete The production Product')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('production-product') }}
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
                    @can('production_product.create')
                        <a data-placement="bottom" title="Create New Production Product" type="button" class="btn btn-info" href ="{{ route('admin.production-product.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('Create Sample Product')}}</a>
                    @endcan
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.product.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Code')}}</th>
                                <th>{{_lang('Articel')}}</th>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Category')}}</th>
                                <th>{{_lang('Sub Category')}}</th>
                                <th>{{_lang('Status')}}</th>
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
    <script src="{{ asset('js/production/product.js') }}"></script>
@endpush

