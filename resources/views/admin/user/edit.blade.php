@extends('layouts.app', ['title' => _lang('user_role'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Edit User Information."><i class="fa fa-users mr-4"></i> {{_lang('Edit User')}}</h1>
            <p>{{_lang('Create Users For This System.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('/edit', $user->id) }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
    <div class="tile">
        <div class="tile-body">
            {!! Form::open(['route' => 'admin.user.update', 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
            @method('PUT');
                <input type="hidden" name="id" value="{{$user->id}}">
                <fieldset class="mb-3" id="form_field">
                    <div class="row">
                        <div class="col-md-2">
                            {{-- Prefix --}}
                            <div class="form-group">
                                {{ Form::label('surname', _lang('Prefix') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('surname', $user->surname, ['class' => 'form-control', 'placeholder' => 'Dr/Mr/Mrs','required'=>'']) }}
                            </div>
                        </div>
                        {{-- First Name --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('first_name', _lang('first_name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => _lang('first_name'),'required'=>'']) }}
                            </div>
                        </div>
                        {{-- Last Name --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('last_name', _lang('last_name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => _lang('last_name'),'required'=>'']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('email', _lang('email') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => _lang('email'),'required'=>'']) }}
                            </div>
                        </div>
                        {{-- Role Name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('role', _lang('role_name') , ['class' => 'col-form-label required']) }}
                                {!! Form::select('role', $roles, $user->roles->first()->id, ['class' => 'form-control select', 'data-placeholder' => _lang('select_role')]); !!}
                            </div>
                        </div>
                        {{-- User Name --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('username', _lang('user_name') , ['class' => 'col-form-label required']) }}
                                {{ Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => _lang('user_name'),'required'=>'']) }}
                            </div>
                        </div>
                    </div>
                    {{-- Update Button --}}
                    @can('user.update')
                        <div class="text-right">
                            <button data-placement="bottom" title="Update User Information." type="submit" class="btn btn-primary"  id="submit">{{_lang('update')}}</button>
                            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        </div>
                    @endcan
                <fieldset class="mb-3" id="form_field">
            {!!Form::close()!!}
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script src="{{ asset('js/pages/user.js') }}"></script>
@endpush

