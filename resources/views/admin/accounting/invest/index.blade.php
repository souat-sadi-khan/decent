@extends('layouts.app', ['title' => _lang('Investment Account'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Account."><i class="fa fa-universal-access mr-4"></i> {{_lang('Investment Account')}}</h1>
        <p>{{_lang('Create Investment Account.')}}</p>
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
            @can('accounting.create')
            <button data-placement="bottom" title="Create New Production Brands" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.accounting.investment.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('create')}}</button>
            @endcan
            </h3>
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.accounting.investment.index') }}">
                    <thead>
                        <tr>
                            <td>{{ _lang('Investment Name') }}</td>
                            <th>{{_lang('Account No')}}</th>
                            <th>{{_lang('Note')}}</th>
                            <th>{{_lang('Balance')}}</th>
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
<script src="{{ asset('js/account/invest.js') }}"></script>
@endpush