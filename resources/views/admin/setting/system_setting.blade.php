@extends('layouts.app', ['title' => _lang('setting'), 'modal' => false])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom"
                title="Change Your Software System Configuration from here."><i
                    class="fa fa-cogs mr-4"></i> {{_lang('System Configuration')}}</h1>
            <p>{{_lang('Change Your Software System Configuration from here.')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('system-settings') }}
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
                    <div pclass="bs-component">

                        <!-- Tab panes -->
                        {!! Form::open(['route' => 'admin.setting', 'id' => 'content_form','files' => true, 'method' => 'POST']) !!}
                        {{ Form::hidden('config_type', 'system_setting') }}
                        <div class="tab-content">
                            {{-- This is for Home Section --}}

                                <div class="row">
                                    {{-- Default Sidebar --}}
                                    <div class="col-md-6">
                                        {{ Form::label('default_sidebar', _lang('Default Sidebar') , ['class' => 'col-form-label ']) }}
                                        <select name="default_sidebar" id="default_sidebar" class="form-control select" data-placeholder="Select Default Sidebar">
                                            <option value="">{{_lang('Select Default Sidebar')}}</option>
                                            <option {{get_option('default_sidebar') == '0' ? 'selected' : ''}} value="0">{{_lang('Mini')}}</option>
                                            <option {{get_option('default_sidebar') == '1' ? 'selected' : ''}} value="1">{{_lang('Normal')}}</option>
                                        </select>
                                    </div>

                                    {{-- Default Holiday In a Week --}}
                                    <div class="col-md-6">
                                        {{ Form::label('holiday', _lang('Default Holiday') , ['class' => 'col-form-label ']) }}
                                        <select name="holiday" class="form-control select" data-placeholder="Select A Day">
                                            <option value="">Select A Day</option>
                                            <option {{get_option('holiday') == 'Friday' ? 'selected' : ''}}  value="Friday">Friday</option>
                                            <option {{get_option('holiday') == 'Saturday' ? 'selected' : ''}}  value="Saturday">Saturday</option>
                                            <option {{get_option('holiday') == 'Sunday' ? 'selected' : ''}}  value="Sunday">Sunday</option>
                                            <option {{get_option('holiday') == 'Monday' ? 'selected' : ''}}  value="Monday">Monday</option>
                                            <option  {{get_option('holiday') == 'Tuesday' ? 'selected' : ''}} value="Tuesday">Tuesday</option>
                                            <option {{get_option('holiday') == 'Wednesday' ? 'selected' : ''}}  value="Wednesday">Wednesday</option>
                                            <option {{get_option('holiday') == 'Thursday' ? 'selected' : ''}}  value="Thursday">Thursday</option>
                                        </select>
                                    </div>

                                    {{-- TimeZone --}}
                                    <div class="col-md-6">
                                        {{ Form::label('timezone', _lang('TimeZone') , ['class' => 'col-form-label ']) }}
                                        <select name="timezone" class="form-control select">
                                            @foreach (tz_list() as $key=> $time)
                                                <option {{$time['zone'] == get_option('timezone') ? 'selected' : ''}}  value="{{$time['zone']}}">{{ $time['diff_from_GMT'] . ' - ' . $time['zone']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- Date Foramt --}}
                                    <div class="col-md-6">
                                        {{ Form::label('date_format', _lang('Date Format') , ['class' => 'col-form-label ']) }}
                                        <select name="date_format" id="date_format" class="form-control select" data-placeholder="Select Default Date Format">
                                            <option value="">{{_lang('Select Default Date Format')}}</option>
                                            <option {{get_option('date_format') == 'd-m-Y' ? 'selected' : ''}} value="d-m-Y">{{_lang('DD-MM-YYYY')}}</option>
                                            <option {{get_option('date_format') == 'm-d-Y' ? 'selected' : ''}} value="m-d-Y">{{_lang('MM-DD-YYYY')}}</option>
                                            <option {{get_option('date_format') == 'D-F-Y' ? 'selected' : ''}} value="d-F-Y">{{_lang('DD-MMM-YYYY')}}</option>
                                            <option {{get_option('date_format') == 'F-d-Y' ? 'selected' : ''}} value="F-d-Y">{{_lang('MMM-DD-YYYY')}}</option>
                                        </select>
                                    </div>
                                    {{-- Time Format --}}
                                    <div class="col-md-6">
                                        {{ Form::label('time_format', _lang('Time Format') , ['class' => 'col-form-label ']) }}
                                        <select name="time_format" id="time_format" class="form-control select" data-placeholder="Select Default Time Format">
                                            <option value="">{{_lang('Select Default Time Format')}}</option>
                                            <option {{get_option('time_format') == 'H::i' ? 'selected' : ''}} value="H::i">{{_lang('24 Hour')}}</option>
                                            <option {{get_option('time_format') == 'h:i' ? 'selected' : ''}}  value="h:i">{{_lang('12 Hour')}}</option>
                                            <option {{get_option('time_format') == 'h:i A' ? 'selected' : ''}} value="h:i A">{{_lang('12 Hour Meridiem')}}</option>
                                        </select>
                                    </div>
                                    {{-- Notification Position --}}
                                    <div class="col-md-6">
                                        {{ Form::label('notification_format', _lang('Notification Position') , ['class' => 'col-form-label ']) }}
                                        <select name="notification_format" id="notification_format" class="form-control select" data-placeholder="Select Default Notification Position ">
                                            <option value="">{{_lang('Select Default Notification Position')}}</option>
                                            <option selected {{get_option('notification_format') == 'toast-top-right' ? 'selected' : ''}} value="toast-top-right">{{_lang('Top Right')}}</option>
                                            <option {{get_option('notification_format') == 'toast-top-left' ? 'selected' : ''}} value="toast-top-left">{{_lang('Top Left')}}</option>
                                            <option {{get_option('notification_format') == 'toast-top-full-width' ? 'selected' : ''}} value="toast-top-full-width">{{_lang('Top Full Width')}}</option>
                                            <option {{get_option('notification_format') == 'toast-top-center' ? 'selected' : ''}} value="toast-top-cente">{{_lang('Top Center')}}</option>
                                            <option {{get_option('notification_format') == 'toast-bottom-right' ? 'selected' : ''}} value="toast-bottom-right">{{_lang('Bottom Right')}}</option>
                                            <option {{get_option('notification_format') == 'toast-bottom-left' ? 'selected' : ''}} value="toast-bottom-left">{{_lang('Bottom Left')}}</option>
                                            <option {{get_option('notification_format') == 'toast-bottom-full-width' ? 'selected' : ''}} value="toast-bottom-full-width">{{_lang('Bottom Full Width')}}</option>
                                            <option {{get_option('notification_format') == 'toast-bottom-center' ? 'selected' : ''}} value="toast-bottom-center">{{_lang('Bottom Center')}}</option>
                                        </select>
                                    </div>

                                    {{-- Language --}}
                                    <div class="col-md-6">
                                        {{ Form::label('language', _lang('language') , ['class' => 'col-form-label', 'data-placeholder' => 'Select System Language']) }}
                                        <select name="language" class="form-control select">
                                            <option value="default">{{_lang('Default')}}</option>
                                        {!! load_language( get_option('language') ) !!}
                                    </select>
                                </div>
                                {{-- Currency --}}
                                <div class="col-lg-6">
                                    {{ Form::label('currency', _lang('Currency') , ['class' => 'col-form-label']) }}
                                    <select name="currency" class="form-control select">
                                        @foreach (curency() as $key=> $element)
                                            <option
                                                {{(get_option('currency')?get_option('currency') == $key :'') ? 'selected' : ''}} value="{{$key}}">{!!$element!!}
                                                ({{$key}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Page Lenghth --}}
                                <div class="col-md-6">
                                    {{ Form::label('page_lenght', _lang('Page Length') , ['class' => 'col-form-label ']) }}
                                    <select name="page_lenght" id="page_lenght" class="form-control select"
                                            data-placeholder="Select Default Page Lenght ">
                                        <option value="">{{_lang('Select Default Page Lenght')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '1' ? 'selected' : ''}} value="1">{{_lang('1')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '5' ? 'selected' : ''}} value="5">{{_lang('5')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '10' ? 'selected' : ''}} value="10">{{_lang('10')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '25' ? 'selected' : ''}} value="25">{{_lang('25')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '100' ? 'selected' : ''}} value="100">{{_lang('100')}}</option>
                                        <option
                                            {{get_option('page_lenght') == '500' ? 'selected' : ''}} value="500">{{_lang('500')}}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('set_mail_driver', _lang('Set Mail Driver') , ['class' => 'col-form-label ']) }}
                                    <select name="set_mail_driver" class="form-control select"
                                            data-placeholder="Select Mail Driver">
                                        <option value="">{{_lang('Select Mail Driver')}}</option>
                                        <option
                                            {{get_option('set_mail_driver') == 'sendmail' ? 'selected' : ''}} value="sendmail">{{_lang('SentMail')}}</option>
                                        <option
                                            {{get_option('set_mail_driver') == 'mailgun' ? 'selected' : ''}} value="mailgun">{{_lang('Mailgun')}}</option>
                                        <option
                                            {{get_option('set_mail_driver') == 'smtp' ? 'selected' : ''}} value="smtp">{{_lang('SMTP')}}</option>
                                        <option
                                            {{get_option('set_mail_driver') == 'Log' ? 'selected' : ''}} value="Log">{{_lang('Log')}}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('set_sms_gateway', _lang('Set SMS Gateway') , ['class' => 'col-form-label ']) }}
                                    <select name="set_sms_gateway" class="form-control select"
                                            data-placeholder="Select SMS Gateway">
                                        <option value="">{{_lang('Select SMS Gateway')}}</option>
                                        <option
                                            {{get_option('set_sms_gateway') == 'Nexmo' ? 'selected' : ''}} value="Nexmo">{{_lang('Nexmo')}}</option>
                                        <option
                                            {{get_option('set_sms_gateway') == 'Twillo' ? 'selected' : ''}} value="Twillo">{{_lang('Twillo')}}</option>
                                        <option
                                            {{get_option('set_sms_gateway') == 'Custom' ? 'selected' : ''}} value="Custom">{{_lang('Custom')}}</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6"></div>

                                {{-- Enable Https --}}
                                {{-- <div class="col-md-3 mt-3">
                                   <div  class="border border-secondary p-2 rounded text-center"> 
                                    <label for="enable_https">{{_lang('Enable Https')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input name="enable_https" id="enable_https"
                                                   {{get_option('enable_https') == '1' ? 'checked' : ''}} type="checkbox"
                                                   value="1"><span class="button-indecator text-primary"></span>
                                        </label>
                                    </div>
                                    </div>
                                </div> --}}

                                {{-- Show Error Display --}}
                                {{-- <div class="col-md-3 mt-3">
                                   <div  class="border border-secondary p-2 rounded text-center"> 
                                    <label for="show_error_display">{{_lang('Show Error Display')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input name="show_error_display" id="show_error_display"
                                                   {{get_option('show_error_display') == '1' ? 'checked' : ''}} value="1"
                                                   type="checkbox"><span class="button-indecator text-primary"></span>
                                        </label>
                                       </div>
                                    </div>
                                </div> --}}

                                {{-- Enable FrontEnd Website --}}
                                {{-- <div class="col-md-3 mt-3">
                                     <div  class="border border-secondary p-2 rounded text-center"> 
                                    <label for="enable_frontend_website">{{_lang('Enable FrontEnd Website')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input name="enable_frontend_website" id="enable_frontend_website"
                                                   {{get_option('enable_frontend_website') == '1' ? 'checked' : ''}} type="checkbox"
                                                   value="1"><span class="button-indecator text-primary"></span>
                                        </label>
                                    </div>
                                    </div>
                                </div> --}}

                                {{-- IP Filter--}}
                                {{-- <div class="col-md-3 mt-3">
                                    <div  class="border border-secondary p-2 rounded text-center">
                                    <label for="ip_filter">{{_lang('IP Filter')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input name="ip_filter" value="1" id="ip_filter"
                                                   {{get_option('ip_filter') == '1' ? 'checked' : ''}} type="checkbox"><span
                                                class="button-indecator text-primary"></span>
                                        </label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- To-Do --}}
                                {{-- <div class="col-md-3 mt-3">
                                    <div  class="border border-secondary p-2 rounded text-center">
                                        <label for="todo">{{_lang('To-Do ')}}</label>
                                        <div class="toggle lg">
                                            <label class="mb-0">
                                                <input value="1" name="todo" id="todo"
                                                    {{get_option('todo') == '1' ? 'checked' : ''}} type="checkbox"><span
                                                    class="button-indecator text-primary"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- BackUp --}}
                                {{-- <div class="col-md-3 mt-3">
                                    <div  class="border border-secondary p-2 rounded text-center">
                                    <label for="backup">{{_lang('BackUp ')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input value="1" name="backup" id="backup"
                                                   {{get_option('backup') == '1' ? 'checked' : ''}} type="checkbox"><span
                                                class="button-indecator text-primary"></span>
                                        </label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- Enable Maintenance Mode --}}
                                {{-- <div class="col-md-3 mt-3">
                                    <div  class="border border-secondary p-2 rounded text-center">
                                    <label for="maintenance_mode">{{_lang('Enable Maintenance Mode ')}}</label>
                                    <div class="toggle lg">
                                        <label class="mb-0">
                                            <input name="maintenance_mode" value="1" id="maintenance_mode"
                                                   {{get_option('maintenance_mode') == '1' ? 'checked' : ''}} type="checkbox"><span
                                                class="button-indecator text-primary"></span>
                                        </label>
                                    </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                        @can('system_configuration.update')
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
    <script>
        $(document).on('click', '#maintenance_mode', function () {
            var id = $(this).val();
            if (this.checked == true) {
                var status = 1;
            } else {
                var status = 0;
            }
            $('#maintenance_mode').val(status);
        });

    </script>
@endpush

