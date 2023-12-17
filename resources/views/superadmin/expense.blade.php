@extends('layouts.app', ['title' => _lang('Expense'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Expense."><i class="fa fa-universal-access mr-4"></i> {{_lang('Expense')}}</h1>
        <p>{{_lang('Create Expense. Here you can Add, Edit & Delete The production Brands')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('production-brands') }}
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
                         <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('investment_account_id', _lang('Account').':') !!}
                                {!! Form::select('investment_account_id', $investment, null, ['placeholder' =>
                                _lang('All'),'class' => 'form-control select']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('employee_id', _lang('Expense For').':') !!}
                                {!! Form::select('employee_id', $employeis, null, ['class' => 'form-control select','placeholder' =>
                                _lang('All')]); !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('expense_category_id',_lang('Category').':') !!}
                                {!! Form::select('expense_category_id', $categories, null, ['placeholder' =>
                                _lang('All'), 'class' => 'form-control select', 'style' => 'width:100%', 'id' => 'expense_category_id']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('super_admin.expense') }}">
                    <thead>
                        <tr>
                            <th>{{_lang('id')}}</th>
                            <td>{{_lang('Date') }}</td>
                            <th>{{_lang('Category')}}</th>
                            <th>{{_lang('Expense For')}}</th>
                            <th>{{_lang('Account')}}</th>
                            <th>{{_lang('Amount')}}</th>
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
<script src="{{ asset('js/expense/expense.js') }}"></script>
@endpush