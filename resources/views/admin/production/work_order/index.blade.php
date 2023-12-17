@extends('layouts.app', ['title' => _lang('Production Work Order'), 'modal' => 'lg'])
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
            <h1 data-placement="bottom" title="Work Order for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production Work Order')}}</h1>
            <p>{{_lang('Create Work order for Production. Here you can Add, Edit & Delete The production Work Order')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('production-work-order') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <select class="form-control status_select" id="status">
                    <option value="">All</option>
                    <option value="requisition">Requisition</option>
                    <option value="Not">Not Requisition</option>
                </select>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">
                    @can('production_work_order.create')
                        <a data-placement="bottom" title="Create New Production Work Order" type="button" class="btn btn-info" href ="{{ route('admin.production-work-order.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('New Work Order')}}</a>
                    @endcan
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.work-order.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('Code')}}</th>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Work Orde Date')}}</th>
                                <th>{{_lang('Delivery Date')}}</th>
                                <th>{{_lang('P. Status')}}</th>
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
    <script src="{{ asset('js/production/work_order.js') }}"></script>
    <script>
    $('.status_select').select2({
        width: '88%'
    });
    </script>
@endpush

