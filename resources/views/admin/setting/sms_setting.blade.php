@extends('layouts.app', ['title' => _lang('setting'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom" title="Change Your Software SMS Configuration from here."><i class="fa fa-envelope mr-4"></i> {{_lang('SMS Configuration')}}</h1>
            <p>{{_lang('Change Your Software SMS Configuration from here.')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('sms-settings') }}
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
                                    {{--SMS Gateway --}}
                                    <div class="col-md-6">
                                        {{ Form::label('sms_gateway', _lang('SMS Gateway') , ['class' => 'col-form-label ']) }}
                                        <select name="sms_gateway" id="sms_gateway" class="form-control select" data-placeholder="Select SMS Gateway">
                                            <option value="">{{_lang('Select SMS Gateway')}}</option>
                                            <option {{get_option('sms_gateway') == 'Nexmo' ? 'selected' : ''}} value="Nexmo">{{_lang('Nexmo')}}</option>
                                            <option {{get_option('sms_gateway') == 'Twillo' ? 'selected' : ''}} value="Twillo">{{_lang('Twillo')}}</option>
                                            <option {{get_option('sms_gateway') == 'Custom' ? 'selected' : ''}} value="Custom">{{_lang('Custom')}}</option>
                                        </select>
                                    </div>
                                    {{-- Max SMS in single queue --}}
                                    <div class="col-md-6">
                                        {{ Form::label('max_sms', _lang('Max SMS in single queue') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('max_sms', get_option('max_sms'), ['class' => 'form-control', 'placeholder' => _lang('Type Max SMS in single queue')]) }}
                                    </div>
                                </div>
                                <div class="row" id="nexmo_contain" style="display:none">
                                    {{-- Nexmo Api Key --}}
                                    <div class="col-md-6">
                                        {{ Form::label('nexmo_api_key', _lang('Nexmo Api Key') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('nexmo_api_key', get_option('nexmo_api_key'), ['class' => 'form-control', 'placeholder' => _lang('Type Nexmo Api Key')]) }}
                                    </div>
                                    {{-- Nexmo Api Secret --}}
                                    <div class="col-md-6">
                                        {{ Form::label('nexmo_api_secret', _lang('Nexmo Api Secret') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('nexmo_api_secret', get_option('nexmo_api_secret'), ['class' => 'form-control', 'placeholder' => _lang('Type Nexmo Api Secret')]) }}
                                    </div>
                                    {{-- Nexmo Sender Mobile Number --}}
                                    <div class="col-md-6">
                                        {{ Form::label('nexmo_sender_number', _lang('Nexmo Sender Mobile Number') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('nexmo_sender_number', get_option('nexmo_sender_number'), ['class' => 'form-control', 'placeholder' => _lang('Type Nexmo Sender Mobile Number')]) }}
                                    </div>
                                    {{-- Nexmo Mobile Number For Texting --}}
                                    <div class="col-md-6">
                                        {{ Form::label('nexmo_testing_number', _lang('Nexmo Mobile Number For Texting') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('nexmo_testing_number', get_option('nexmo_testing_number'), ['class' => 'form-control', 'placeholder' => _lang('Type Nexmo Mobile Number For Texting')]) }}
                                    </div>
                                </div>
                                <div class="row" id="twillo_contain" style="display:none">
                                    {{-- Twillo SID --}}
                                    <div class="col-md-6">
                                        {{ Form::label('twillo_sid', _lang('Twillo SID') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('twillo_sid', get_option('twillo_sid'), ['class' => 'form-control', 'placeholder' => _lang('Type Twillo SID')]) }}
                                    </div>
                                     {{-- Twillo Token --}}
                                    <div class="col-md-6">
                                        {{ Form::label('twillo_token', _lang('Twillo Token') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('twillo_token', get_option('twillo_token'), ['class' => 'form-control', 'placeholder' => _lang('Type Twillo Token')]) }}
                                    </div>
                                    {{-- Twillo Sender Mobile Number --}}
                                    <div class="col-md-6">
                                        {{ Form::label('twillo_sender_number', _lang('Twillo Sender Mobile Number') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('twillo_sender_number', get_option('twillo_sender_number'), ['class' => 'form-control', 'placeholder' => _lang('Type Twillo Sender Mobile Number')]) }}
                                    </div>
                                    {{-- Twillo Mobile Number For Texting --}}
                                    <div class="col-md-6">
                                        {{ Form::label('twillo_testing_number', _lang('Twillo Mobile Number For Texting') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('twillo_testing_number', get_option('twillo_testing_number'), ['class' => 'form-control', 'placeholder' => _lang('Type Twillo Mobile Number For Texting')]) }}
                                    </div>
                                </div>
                                <div class="row" id="custom_contain" style="display:none">
                                         {{--Custom API Number Prefix --}}
                                    <div class="col-md-6">
                                        {{ Form::label('sms_route', _lang('Sms Route') , ['class' => 'col-form-label ']) }}
                                           <select name="sms_route" id="sms_route" class="form-control select" data-placeholder="Select SMS Gateway">
                                            <option value="">{{_lang('Select SMS Route')}}</option>
                                            <option {{get_option('sms_route') == 'bulck_route' ? 'selected' : ''}} value="bulck_route">{{_lang('Bulk SMS Route')}}</option>
                                            <option {{get_option('sms_route') == 'solutionbd' ? 'selected' : ''}} value="solutionbd">{{_lang('IT Solutionbd')}}</option>
                                            <option {{get_option('sms_route') == 'zaman_it' ? 'selected' : ''}} value="zaman_it">{{_lang('Zaman IT')}}</option>
                                            <option {{get_option('sms_route') == 'mim_sms' ? 'selected' : ''}} value="mim_sms">{{_lang('MIM SMS')}}</option>
                                        </select>
                                    </div>
                                    {{--Custom API Get URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('custom_api_url', _lang('API Get URL') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('custom_api_url', get_option('custom_api_url'), ['class' => 'form-control', 'placeholder' => _lang('Type API Get URL')]) }}
                                    </div>
                                
                   
                                     {{--Custom API Sender Id/Number --}}
                                    <div class="col-md-6">
                                        {{ Form::label('custom_api_sender_id', _lang('API Sender Id/Number') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('custom_api_sender_id', get_option('custom_api_sender_id'), ['class' => 'form-control', 'placeholder' => _lang('Type API Sender Id/Number')]) }}
                                    </div>
                                     {{--Custom API Receiver Parameter --}}
                                    <div class="col-md-6">
                                        {{ Form::label('custom_api_key', _lang('API Key') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('custom_api_key', get_option('custom_api_key'), ['class' => 'form-control', 'placeholder' => _lang('Type API Key')]) }}
                                    </div>
                                     {{--Custom API Message Parameter --}}
                                    <div class="col-md-6">
                                        {{ Form::label('custom_api_secret', _lang('API Secret') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('custom_api_secret', get_option('custom_api_secret'), ['class' => 'form-control', 'placeholder' => _lang(' API Secret')]) }}
                                    </div>
                             
                                </div>
                        </div>
                        @can('sms_configuration.update')
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

