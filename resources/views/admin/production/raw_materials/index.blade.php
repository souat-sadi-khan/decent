@extends('layouts.app', ['title' => _lang('Production Raw Materials'), 'modal' => 'lg'])
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
            <h1 data-placement="bottom" title="Raw Materials for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Raw Materials')}}</h1>
            <p>{{_lang('Create Raw Materials for Production. Here you can Add, Edit & Delete The production Raw Materials')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('production-raw-materials') }}
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
                    @can('raw_material.create')
                        <button data-placement="bottom" title="Create raw materials for production" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.production-raw-materials.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('New Raw Material')}}</button>
                    @endcan
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{route('admin.raw-materials.datatable')}}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Unit Name')}}</th>
                                <th>{{_lang('Material name')}}</th>
                                <th>{{_lang('price')}}</th>
                                <th>{{_lang('Description')}}</th>
                                <th>{{_lang('Stock')}}</th>
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

<div class="modal fade border-top-success rounded-top-0 unit_modal" role="dialog" >
</div>

{{-- Script Section --}}
@push('scripts')
    <script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script src="{{ asset('js/production/raw_materials.js') }}"></script>
@endpush

