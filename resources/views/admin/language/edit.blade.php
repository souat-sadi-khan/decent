@extends('layouts.app', ['title' => _lang('language'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Translate The Language."><i class="fa fa-language mr-4"></i> {{_lang('Translate Language')}}</h1>
            <p>{{_lang('Translate The Language As Per You Want...')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('language/edit') }}
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
                    {!! Form::open(['route' => ['admin.language.update',$id], 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
                    @method('patch')
                        <div class="row">
                            @foreach($language as $key=>$lang)
                                <div class="col-md-6">
                                    {{ Form::label('language_name', ucwords($key) , ['class' => 'col-form-label required']) }}
                                    <input type="text" class="form-control" name="language[{{ str_replace(' ','_',$key) }}]" value="{{ $lang }}" required>
                                 </div>
                            @endforeach
                        </div>
                        @can('language.update')
                            <div class="text-right mt-2">
                                <button data-placement="bottom" title="Update The Translation For This Language" type="submit" class="btn btn-primary"  id="submit">{{_lang('translation')}}<i class="icon-arrow-right14 position-right"></i></button>
                                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{ _lang('processing') }}<i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                            </div>
                        @endcan
                    {!!Form::close()!!}
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
    <script src="{{ asset('js/pages/setting.js') }}"></script>
@endpush

