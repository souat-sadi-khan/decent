@extends('layouts.app', ['title' => _lang('Account'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Account."><i class="fa fa-universal-access mr-4"></i> {{_lang('Account')}}</h1>
        <p>{{_lang('Create Account.')}}</p>
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
            <button data-placement="bottom" title="Create New Production Brands" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.accounting.account.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('New Account')}}</button>
            @endcan
            </h3>
            <div class="tile-body">
                @if(!empty($not_linked_payments))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            <ul>
                                @if(!empty($not_linked_payments))
                                <li>{!! $not_linked_payments ._lang('Payment Not Link to Any account') !!} <a href="{{ route('admin.accounting.payment_account') }}">{{ _lang('Details') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.accounting.account.index') }}">
                    <thead>
                        <tr>
                            <td>{{ _lang('Name') }}</td>
                            <th>{{_lang('Account No')}}</th>
                            <th>{{_lang('Account Type')}}</th>
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
<script src="{{ asset('js/account/account.js') }}"></script>
@endpush