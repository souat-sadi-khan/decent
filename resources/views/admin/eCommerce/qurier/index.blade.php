@extends('layouts.app', ['title' => _lang('Ecommerce Qurier'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Employee Shift for Users."><i class="fa fa-clock-o mr-4"></i> {{_lang('Ecommerce Qurier')}}</h1>
            <p>{{_lang('Create Ecommerce Qurier for Users. Here you can Add, Edit & Delete The Employee Shift')}}</p>
        </div>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('ecommerce_qurier.create')
                    <h3 class="tile-title">
                        <button data-placement="bottom" title="Create New Ecommerce Qurier Option" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.eCommerce.qurier.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    </h3>
                @endcan 
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.qurier.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Phone')}}</th>
                                <th>{{_lang('Address')}}</th>
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
    <script src="{{ asset('js/eCommerce/qurier.js') }}"></script>
@endpush

