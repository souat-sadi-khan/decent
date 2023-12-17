@extends('layouts.app', ['title' => _lang('Production WOP Material'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="WOP Material for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production WOP Material')}}</h1>
            <p>{{_lang('Create WOP Material for Production. Here you can Add, Edit & Delete The production WOP Material')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('wop-materials') }}
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
                    @can('production_wop_materials.create')
                        <a data-placement="bottom" title="Create New Production Product" type="button" class="btn btn-info" href ="{{ route('admin.production-wop-materials.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</a>
                    @endcan
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.wop-materials.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('SL')}}</th>
                                <th>{{_lang('Type')}}</th>
                                <th>{{_lang('Work Orde Date')}}</th>
                                <th>{{_lang('Delivary Date')}}</th>
                                <th>{{_lang('Value')}}</th>
                                <th>{{ _lang('Status') }}</th>
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
@endpush

