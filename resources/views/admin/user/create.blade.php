@extends('layouts.app', ['title' => _lang('user_role'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Create New User System For this Software."><i class="fa fa-users mr-4"></i> {{_lang('Create User')}}</h1>
            <p>{{_lang('Create Users For This System.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('/create') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
    <div class="tile">
        <div class="tile-body">
            <!-- Basic initialization -->
            {!! Form::open(['route' => 'admin.user.create', 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
                <fieldset class="mb-3" id="form_field">
                    <div class="row">
                        <div class="col-md-9 mx-auto">
                             <div class="form-group">
                            {{ Form::label('employee_id', _lang('Employee') , ['class' => 'col-form-label required']) }}
                                {!! Form::select('employee_id', $employies, null, ['class' => 'form-control select','id'=>'employee_id', 'data-placeholder' => 'Select A employee','required'=>'', 'data-parsley-errors-container' => '#parsley_division_error_area']); !!}
                                <span id="parsley_division_error_area"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Prefix --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('surname', _lang('Prefix') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('surname', null, ['class' => 'form-control', 'placeholder' => 'Dr/Mr/Mrs','required'=>'']) }}
                            </div>
                        </div>
                        {{-- First Name --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('first_name', _lang('first_Name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => _lang('first_Name'),'required'=>'']) }}
                            </div>
                        </div>
                        {{-- Last Name --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('last_name', _lang('last_Name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => _lang('last_Name'),'required'=>'']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('email', _lang('email') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => _lang('email'),'required'=>'']) }}
                            </div>
                        </div>
                        {{-- Role Name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                            {{ Form::label('role', _lang('role_Name') , ['class' => 'col-form-label required']) }}
                                {!! Form::select('role', $roles, null, ['class' => 'form-control select', 'data-placeholder' => 'Select A Role','required'=>'', 'data-parsley-errors-container' => '#parsley_division_error_area']); !!}
                                <span id="parsley_division_error_area"></span>
                            </div>
                        </div>
                        {{-- User Name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('username', _lang('user_name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => _lang('user_name'),'required'=>'']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Password --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('password', _lang('password') , ['class' => 'col-form-label required']) }}
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => _lang('password'),'required'=>'']) }}
                            </div>
                        </div>
                        {{-- Confirm Password --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                    {{ Form::label('password_confirmation', _lang('confirm_password') , ['class' => 'col-form-label required']) }}
                                    {{ Form::password('password_confirmation',['class' => 'form-control', 'placeholder' => _lang('confirm_password'),'required'=>'']) }}
                                </div>
                            </div>
                        </div>
                        {{-- Submit Button --}}
                        @can('user.create')
                            <div class="text-right">
                                <button  data-placement="bottom" title="Create New User." type="submit" class="btn btn-primary"  id="submit">{{_lang('Create User')}}</button>
                                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                            </div>
                        @endcan
                    <fieldset class="mb-3" id="form_field">
                {!!Form::close()!!}
            </div>
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script src="{{ asset('js/pages/user.js') }}"></script>
@endpush

