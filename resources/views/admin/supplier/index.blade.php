@extends('layouts.app', ['title' => _lang('Supplier'), 'modal' => 'lg'])
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
        <h1 data-placement="bottom" title="Supplier."><i class="fa fa-universal-access mr-4"></i> {{_lang('Supplier')}}</h1>
        <p>{{_lang('Create Supplier. Here you can Add, Edit & Delete Supplier')}}</p>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">
            @can('client.create')
            <button data-placement="bottom" title="Create New Production Brands" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.client.create',['type'=>'supplier']) }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('Create New Supplier')}}</button>
            @endcan
            </h3>
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.get_supplier_index') }}">
                    <thead>
                        <tr>
                            <th>{{_lang('Name')}}</th>
                            <th>{{_lang('Sub Type')}}</th>
                            <th>{{_lang('Mobile')}}</th>
                            <th>{{_lang('Address')}}</th>
                            <th>{{_lang('Email')}}</th>
                            <th>{{_lang('Purchase Due')}}</th>
                            <th>{{_lang('Return Due')}}</th>
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
{{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('js/client/client.js') }}"></script>
@endpush