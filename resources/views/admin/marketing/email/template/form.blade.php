@php
$route = 'admin.emailmarketing.template.';
@endphp
@extends('layouts.app', ['title' => _lang('Email Template Create'),'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Email Template."><i class="fa fa-universal-access mr-4"></i>
    {{_lang('Email Template Create')}}</h1>
    <p>{{_lang('Create Email Template.')}}</p>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Email Template')}}</h6>
  </div>
  <div class="card-body">
    @if(isset($model))
    {!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
    @else
    {!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('name', _lang('Title') , ['class' => 'col-form-label']) }}
          {{ Form::text('name', null, ['class' => 'form-control input_number', 'id'=>'name', 'placeholder' => _lang('Title'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('template', _lang('Template') , ['class' => 'col-form-label']) }}
          <button type="button" class="btn btn-success btn-sm" id="content_managment" data-url ="{{ url('admin/emailmarketing/media/import') }}">Import <i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
          {!! Form::textarea('template',null, ['id' => 'summernote', 'class' =>'form-control', 'required' => 'true']) !!}
          <span class="text-danger">Use this variable {USERNAME} to show user name</span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mx-auto text-center">
        
        {{ Form::submit(isset($model) ? _lang('Update'):_lang('Create'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
       <button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
   $(document).ready(function() {
       $('#summernote').summernote({
           height: 300
       });
   });

  function useMedia(media_path) {
        $('#modal_remote').modal('toggle');
        $('#summernote').summernote('insertImage', media_path);
  }
   $(document).on('click', '#content_managment', function(e) {
       e.preventDefault();
       //open modal
       $('#modal_remote').modal('toggle');
       // it will get action url
       var url = $(this).data('url');
       // leave it blank before ajax call
       $('.modal-body').html('');
       // load ajax loader
       $('#modal-loader').show();
       $.ajax({
               url: url,
               type: 'Get',
               dataType: 'html'
           })
           .done(function(data) {
               $('.modal-body').html(data).fadeIn(); // load response
               $('#modal-loader').hide();
           })
           .fail(function(data) {
               $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
               $('#modal-loader').hide();
           });
   });
   _formValidation();
</script>
@endpush