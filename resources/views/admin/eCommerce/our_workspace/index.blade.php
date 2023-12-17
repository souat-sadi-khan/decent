@extends('layouts.app', ['title' => _lang('Our Workspace'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Our worksapce"><i class="fa fa-universal-access mr-4"></i> {{_lang('Our worksapce')}}</h1>
            <p>{{_lang('Here you can Add, Edit & Delete worksapce')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('eCommerce.our-worksapce') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('ecommerce_our_workspace.create')
                    <h3 class="tile-title">
                        <a data-placement="bottom" title="Create New workspace" type="button" class="btn btn-info" href ="{{ route('admin.eCommerce.our-workspace.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</a>
                    </h3>
                @endcan
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.our-workspace.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Image One')}}</th>
                                <th>{{_lang('Image Two')}}</th>
                                <th>{{_lang('Image Three')}}</th>
                                <th>{{_lang('Image Four')}}</th>
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
    <script src="{{ asset('js/eCommerce/our_workspace.js') }}"></script>
@endpush

