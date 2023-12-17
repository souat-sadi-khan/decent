@extends('layouts.app', ['title' => _lang('Production Purchases'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Purchases for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production Purchases')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('purchase') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
       
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('employee_id',  _lang('Purchase For') . ':') !!}
                                {!! Form::select('employee_id', $employeis, null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('status',  _lang('Purchase Status') . ':') !!}
                                {!! Form::select('status', ['Received'=>'Received','Pending'=>'Pending','Ordered'=>'Ordered'], null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('payment_status',  _lang('Payment Status') . ':') !!}
                                {!! Form::select('payment_status', ['Paid' => _lang('Paid'), 'Due' => _lang('Due'), 'Partial' => _lang('Partial')], null, ['class' => 'form-control select', 'style' => 'width:100%', 'placeholder' => _lang('All')]); !!}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('super_admin.purchase') }}">
                    <thead>
                        <tr>
                            <th>{{_lang('SL')}}</th>
                            <th>{{_lang('Purchase By')}}</th>
                            <th>{{_lang('Company')}}</th>
                            <th>{{_lang('Reference No')}}</th>
                            <th>{{_lang('Invoice No')}}</th>
                            <th>{{_lang('Purchase Date')}}</th>
                            <th>{{_lang('Grand Total')}}</th>
                            <th>{{_lang('Purchase Status')}}</th>
                            <th>{{_lang('Payment Status')}}</th>
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
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
{{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('js/production/purchase.js') }}"></script>
@endpush