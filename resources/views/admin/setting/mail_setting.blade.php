@extends('layouts.app', ['title' => _lang('setting'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom" title="Change Your Software Mail Configuration from here."><i class="fa fa-envelope mr-4"></i> {{_lang('Mail Configuration')}}</h1>
            <p>{{_lang('Change Your Software Mail Configuration from here.')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('mail-settings') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="bs-component">

                    <!-- Tab panes -->
                    {!! Form::open(['route' => 'admin.setting', 'id' => 'content_form','files' => true, 'method' => 'POST']) !!}
                        <div class="tab-content">
                            {{-- This is for Home Section --}}
                                <div class="row">
                                    {{--Mail Driver --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mail_driver', _lang('Mail Driver') , ['class' => 'col-form-label ']) }}
                                        <select name="mail_driver" id="mail_driver" class="form-control select" data-placeholder="Select Mail Driver">
                                            <option value="">{{_lang('Select Mail Driver')}}</option>
                                            <option {{get_option('mail_driver') == 'sendmail' ? 'selected' : ''}} value="sendmail">{{_lang('SentMail')}}</option>
                                            <option {{get_option('mail_driver') == 'mailgun' ? 'selected' : ''}} value="mailgun">{{_lang('Mailgun')}}</option>
                                            <option {{get_option('mail_driver') == 'smtp' ? 'selected' : ''}} value="smtp">{{_lang('SMTP')}}</option>
                                            <option {{get_option('mail_driver') == 'Log' ? 'selected' : ''}} value="Log">{{_lang('Log')}}</option>
                                        </select>
                                    </div>
                                    {{-- From Name --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mail_from_name', _lang('From Name') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mail_from_name', get_option('mail_from_name'), ['class' => 'form-control', 'placeholder' => _lang('Type From Name')]) }}
                                    </div>

                                    {{-- From Address --}}
                                    <div class="col-md-12">
                                        {{ Form::label('mail_from_address', _lang('From Address') , ['class' => 'col-form-label ']) }}
                                        {{ Form::textarea('mail_from_address', get_option('mail_from_address'), ['class' => 'form-control', 'rows' => 4, 'placeholder' => _lang('Type From Address')]) }}
                                    </div>
                                </div>
                                <div class="row" id="mailgun_contain" style="display:none">
                                    {{-- Mailgun Domain --}}
                                    <div class="col-md-4">
                                        {{ Form::label('mailgun_domain', _lang('Domain') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_domain', get_option('mailgun_domain'), ['class' => 'form-control', 'placeholder' => _lang('Type Domain')]) }}
                                    </div>
                                    {{-- Mailgun Secret --}}
                                    <div class="col-md-4">
                                        {{ Form::label('mailgun_secret', _lang('Secret') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_secret', get_option('mailgun_secret'), ['class' => 'form-control', 'placeholder' => _lang('Type Secret')]) }}
                                    </div>
                                    {{-- Mailgun Host --}}
                                    <div class="col-md-4">
                                        {{ Form::label('mailgun_host', _lang('Host') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_host', get_option('mailgun_host'), ['class' => 'form-control', 'placeholder' => _lang('Type Host')]) }}
                                    </div>
                                    {{-- Mailgun Port --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mailgun_port', _lang('Port') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_port', get_option('mailgun_port'), ['class' => 'form-control', 'placeholder' => _lang('Type Port')]) }}
                                    </div>
                                    {{-- Mailgun Username --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mailgun_username', _lang('Username') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_username', get_option('mailgun_username'), ['class' => 'form-control', 'placeholder' => _lang('Type Username')]) }}
                                    </div>
                                    {{-- Mailgun Password --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mailgun_password', _lang('Password') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('mailgun_password', get_option('mailgun_password'), ['class' => 'form-control', 'placeholder' => _lang('Type Password')]) }}
                                    </div>
                                    {{-- Mailgun Encryption --}}
                                    <div class="col-md-6">
                                        {{ Form::label('mailgun_encryption', _lang('Encryption') , ['class' => 'col-form-label ']) }}
                                        <select name="mailgun_encryption" id="mailgun_encryption" class="form-control" data-placeholder="Select Encryption">
                                            <option value="">{{_lang('Select Encryption')}}</option>
                                            <option {{get_option('mailgun_encryption') == 'SSL' ? 'selected' : ''}} value="SSL">{{_lang('SSL')}}</option>
                                            <option {{get_option('mailgun_encryption') == 'TLS' ? 'selected' : ''}} value="TLS">{{_lang('TLS')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="smtp_contain" style="display:none">
                                    {{-- smtp Host --}}
                                    <div class="col-md-4">
                                        {{ Form::label('smtp_host', _lang('Host') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('smtp_host', get_option('smtp_host'), ['class' => 'form-control', 'placeholder' => _lang('Type Host')]) }}
                                    </div>
                                    {{-- smtp Port --}}
                                    <div class="col-md-4">
                                        {{ Form::label('smtp_port', _lang('Port') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('smtp_port', get_option('smtp_port'), ['class' => 'form-control', 'placeholder' => _lang('Type Port')]) }}
                                    </div>
                                    {{-- smtp Username --}}
                                    <div class="col-md-4">
                                        {{ Form::label('smtp_username', _lang('Username') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('smtp_username', get_option('smtp_username'), ['class' => 'form-control', 'placeholder' => _lang('Type Username')]) }}
                                    </div>
                                    {{-- smtp Password --}}
                                    <div class="col-md-6">
                                        {{ Form::label('smtp_password', _lang('Password') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('smtp_password', get_option('smtp_password'), ['class' => 'form-control', 'placeholder' => _lang('Type Password')]) }}
                                    </div>
                                    {{-- smtp Encryption --}}
                                    <div class="col-md-6">
                                        {{ Form::label('smtp_encryption', _lang('Encryption') , ['class' => 'col-form-label ']) }}
                                        <select name="smtp_encryption" id="smtp_encryption" class="form-control" data-placeholder="Select Encryption">
                                            <option value="">{{_lang('Select Encryption')}}</option>
                                            <option {{get_option('smtp_encryption') == 'SSL' ? 'selected' : ''}} value="SSL">{{_lang('SSL')}}</option>
                                            <option {{get_option('smtp_encryption') == 'TLS' ? 'selected' : ''}} value="TLS">{{_lang('TLS')}}</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        @can('mail_configuration.update')
                            {{-- This is for submit Button --}}
                            <div class="text-right mr-2 mt-4">
                                <button data-placement="bottom" title="Update The Change"  type="submit" class="btn btn-primary"  id="submit">{{_lang('Update Setting')}}</button>
                                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{ _lang('processing') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                            </div>
                        @endcan
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script src="{{ asset('js/pages/setting.js') }}"></script>
@endpush

