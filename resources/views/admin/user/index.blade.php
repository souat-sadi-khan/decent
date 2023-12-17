@extends('layouts.app', ['title' => _lang('user'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="User System For this Software."><i class="fa fa-users mr-4"></i> {{_lang('User')}}</h1>
            <p>{{_lang('Create Users For This System. Here you can Add, Edit & Delete The User Information.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('/') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('user.create')
                    <h3 class="tile-title">
                        <a data-placement="bottom" title="Create New User." href="{{ route('admin.user.create') }}" class="btn btn-info"><i class="fa fa-plus-square mr-2"></i>{{_lang('create')}}</a>
                    </h3>
                @endcan
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.user.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('user_name')}}</th>
                                <th>{{_lang('email')}}</th>
                                <th>{{_lang('role')}}</th>
                                <th>{{_lang('status')}}</th>
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
    <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script src="{{ asset('js/pages/user.js') }}"></script>
@endpush

