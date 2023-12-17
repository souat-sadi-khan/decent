@extends('layouts.app', ['title' => _lang('Client'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Client."><i class="fa fa-universal-access mr-4"></i> {{_lang('Client')}}</h1>
            <p>{{_lang('Create Client. Here you can Add, Edit & Delete Client')}}</p>
        </div>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
            
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('super_admin.client') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Mobile')}}</th>
                                <th>{{_lang('Address')}}</th>
                                <th>{{_lang('Email')}}</th>
                                <th>{{_lang('Sale Due')}}</th>
                                <th>{{_lang('Return Due')}}</th>
                                <th>{{_lang('Hidden')}}</th>
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

