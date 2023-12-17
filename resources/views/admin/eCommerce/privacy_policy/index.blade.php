@extends('layouts.app', ['title' => _lang('Privacy Policy'),'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/tagsinput.css')}}">
@endpush
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Email Template."><i class="fa fa-universal-access mr-4"></i>
    {{_lang('Privacy Policy Create')}}</h1>
    <p>{{_lang('Privacy and Ploicy for Your Company')}}</p>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Privacy and Policy')}}</h6>
  </div>
  <div class="card-body">
    <form action="{{route('admin.eCommerce.privacy-policy.store')}}" id='content_form' class ='form-validate-jquery' method="post" >
    <input type="hidden" name="row_id" value="{{isset($model)?$model->id:''}}">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label for="name">{{_lang('Title')}}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{isset($model)?$model->name:''}}">
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
             <label for="name">{{_lang('description')}}</label>
             <textarea name="description" class='form-control' id="summernote" required>{{isset($model)?$model->description:''}}</textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Submit')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>
   </form>
  </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{asset('backend/js/tagsinput.js')}}"></script>
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