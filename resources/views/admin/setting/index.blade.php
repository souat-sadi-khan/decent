@extends('layouts.app', ['title' => _lang('setting'), 'modal' => false])

<style>
.nav-pills .nav-link {
    border-radius: 0.25rem;
    background-color: #eceaea;
    margin: 0px 6px;
}
</style>

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom" title="Change Your Software Information & other necessary from here."><i class="fa fa-cogs mr-4"></i> {{_lang('setting')}}</h1>
            <p>{{_lang('Change Your Software Information & other necessary from here...')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('settings') }}
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
                        {{-- Tab Panel --}}
                        <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                            <li class="nav-item">
                                <a data-placement="bottom" title="Update Your Software Information from here." class="nav-link active" data-toggle="pill" href="#home">{{_lang('home')}}</a>
                            </li>
                            <li class="nav-item">
                                <a data-placement="bottom" title="Update Your Software Logo & Favicon from here." class="nav-link" data-toggle="pill" href="#menu1">{{_lang('logo')}}</a>
                            </li>
                            <li class="nav-item">
                                <a data-placement="bottom" title="Update Your Social Links from here." class="nav-link" data-toggle="pill" href="#menu2">{{_lang('basic')}}</a>
                            </li>
                        </ul>

                    <!-- Tab panes -->
                    {!! Form::open(['route' => 'admin.setting', 'id' => 'content_form','files' => true, 'method' => 'POST']) !!}
                        <div class="tab-content">

                            {{-- This is for Home Section --}}
                            <div id="home" class="container tab-pane active">
                                <div class="row">
                                    {{-- Institute Name --}}
                                    <div class="col-md-6">
                                        {{ Form::label('institute_name', _lang('Institute Name') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('institute_name', get_option('institute_name'), ['class' => 'form-control', 'placeholder' => _lang('Enter Your Institute Name')]) }}
                                    </div>
                                    {{-- Institute Running Body --}}
                                    <div class="col-md-6">
                                        {{ Form::label('institute_running_body', _lang('Institute Running Body') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('institute_running_body', get_option('institute_running_body'), ['class' => 'form-control', 'placeholder' => _lang('Enter Your Institute Running Body Name')]) }}
                                    </div>
                                    {{-- Institute Recognition Number --}}
                                    <div class="col-md-6">
                                        {{ Form::label('institute_recognition_number', _lang('Institute Recognition Number') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('institute_recognition_number', get_option('institute_recognition_number'), ['class' => 'form-control', 'placeholder' => _lang('Enter Your Institute Recognition Body Name')]) }}
                                    </div>
                                    {{-- Institute Recognition Body --}}
                                    <div class="col-md-6">
                                        {{ Form::label('institute_recognition_body', _lang('Institute Recognition Body') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('institute_recognition_body', get_option('institute_recognition_body'), ['class' => 'form-control', 'placeholder' => _lang('Enter Your Institute Recognition Body Name')]) }}
                                    </div>
                                    {{-- Address --}}
                                    <div class="col-md-6">
                                        {{ Form::label('address', _lang('Address') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('address', get_option('address'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Address')]) }}
                                    </div>
                                    {{-- Address 2 --}}
                                    <div class="col-md-6">
                                        {{ Form::label('address', _lang('Optional Address') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('address_2', get_option('address_2'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Optional More Address')]) }}
                                    </div>
                                      <div class="col-md-6">  
                                        {{ Form::label('address_optional', _lang('Optional More Address') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('address_optional', get_option('address_optional'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Optional More Address')]) }}
                                    </div>
                                    {{-- City --}}
                                    <div class="col-md-6">
                                        {{ Form::label('city', _lang('City') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('city', get_option('city'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute City')]) }}
                                    </div>
                                    {{-- Statu/County --}}
                                    <div class="col-md-6">
                                        {{ Form::label('state', _lang('Statu/County') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('state', get_option('state'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Statu/County')]) }}
                                    </div>
                                    {{-- Zip/ Postal Code --}}
                                    <div class="col-md-6">
                                        {{ Form::label('zip', _lang('Zip/ Postal Code') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('zip', get_option('zip'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Zip/ Postal Code')]) }}
                                    </div>
                                    {{-- Country --}}
                                    <div class="col-md-6">
                                        {{ Form::label('country', _lang('Country') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('country', get_option('country'), ['class' => 'form-control', 'placeholder' => _lang('Enter Institute Country')]) }}
                                    </div>
                                    {{-- Site Title --}}
                                    <div class="col-md-6">
                                        {{ Form::label('site_title', _lang('title') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('site_title', get_option('site_title'), ['class' => 'form-control', 'placeholder' => _lang('title')]) }}
                                    </div>
                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        {{ Form::label('email', _lang('email') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('email', get_option('email'), ['class' => 'form-control', 'placeholder' => _lang('email')]) }}
                                    </div>
                                    {{-- Phone --}}
                                    <div class="col-md-6">
                                        {{ Form::label(_lang('phone'), _lang('phone') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('phone',get_option('phone'), ['class' => 'form-control', 'placeholder' => _lang('phone')]) }}
                                    </div>
                                    {{-- Alternative Phone --}}
                                    <div class="col-md-6">
                                        {{ Form::label('alt_phone', _lang('alernative_phone') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('alt_phone', get_option('alt_phone'), ['class' => 'form-control', 'placeholder' => _lang('alernative_phone')]) }}
                                    </div>
                                    {{-- Starting Date --}}
                                    <div class="col-md-6">
                                        {{ Form::label('start_date', _lang('starting_date') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('start_date', get_option('start_date'), ['class' => 'form-control date', 'placeholder' => _lang('starting_date')]) }}
                                    </div>
                                    {{-- Fax --}}
                                    <div class="col-md-6">
                                        {{ Form::label('fax', _lang('Fax') , ['class' => 'col-form-label']) }}
                                        {{ Form::text('fax', get_option('fax'), ['class' => 'form-control', 'placeholder' => _lang('Institute Fax Number')]) }}
                                    </div>
                                    {{-- Website URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('website_url', _lang('Website URL') , ['class' => 'col-form-label']) }}
                                        {{ Form::text('website_url', get_option('website_url'), ['class' => 'form-control', 'placeholder' => _lang('Institute Website URL')]) }}
                                    </div>

                                    {{-- Website URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('default_brand', _lang('Default Brand') , ['class' => 'col-form-label ']) }}
                                        <select name="default_brand" id="default_brand" class="form-control select" data-placeholder="Select Brand">
                                            <option value="">{{_lang('Select Brand')}}</option>
                                            @foreach ($brand as $item)
                                            <option {{get_option('default_brand') == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Company Description--}}
                                    <div class="col-md-12">
                                        {{ Form::label('description', _lang('Company Description') , ['class' => 'col-form-label ']) }}
                                        {{ Form::textarea('description', get_option('description'), ['class' => 'form-control', 'rows' => 4, 'placeholder' => _lang('Type Company Description')]) }}
                                    </div>


                                </div>
                            </div>

                            {{-- This is for menu Section --}}
                            <div id="menu1" class="container tab-pane fade">
                                <div class="row">
                                    {{-- Logo --}}
                                    <div class="col-md-6">
                                        {{ Form::label('logo', _lang('logo') , ['class' => 'col-form-label']) }}
                                        <input type="file" name="logo">
                                        @if(get_option('logo'))
                                            <input type="hidden" name="oldLogo" value="{{get_option('logo')}}">
                                        @endif
                                    </div>
                                    {{-- FavIcon --}}
                                    <div class="col-md-6">
                                        {{ Form::label('favicon', _lang('favicon') , ['class' => 'col-form-label']) }}
                                        <input type="file" name="favicon">
                                        @if(get_option('favicon'))
                                            <input type="hidden" name="oldfavicon" value="{{get_option('favicon')}}">
                                        @endif
                                    </div>

                                    <span class="text-danger">Logo Size must be (100 X 28) Size. Otherwise Logo will be broken</span>
                                </div> 
                            </div>

                            {{-- This is for menu2 Section --}}
                            <div id="menu2" class="container tab-pane fade"><br>
                                <div class="row">
                                    {{-- Facebook URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('fb', _lang('facebook_link') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('fb', get_option('fb'), ['class' => 'form-control ', 'placeholder' => _lang('facebook_link')]) }}
                                    </div>
                                    {{-- Twitter URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('twiter', _lang('twiter') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('twiter', get_option('twiter'), ['class' => 'form-control ', 'placeholder' => _lang('twiter')]) }}
                                    </div>
                                    {{-- Youtube URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('youtube', _lang('youtube') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('youtube', get_option('youtube'), ['class' => 'form-control ', 'placeholder' => _lang('youtube')]) }}
                                    </div>
                                    {{-- LinkedIn URL --}}
                                    <div class="col-md-6">
                                        {{ Form::label('linkedin', _lang('linkedin') , ['class' => 'col-form-label ']) }}
                                        {{ Form::text('linkedin', get_option('linkedin'), ['class' => 'form-control ', 'placeholder' => _lang('linkedin')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('setting.update')
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

