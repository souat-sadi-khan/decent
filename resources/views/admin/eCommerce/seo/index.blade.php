@extends('layouts.app', ['title' => _lang('Home Page SEO '),'modal' => 'lg'])
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/tagsinput.css')}}">
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="SEO"><i class="fa fa-universal-access mr-4"></i>
    {{_lang('SEO')}}</h1>
    <p>{{_lang('Add SEO for Home Page')}}</p>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('SEO')}}</h6>
  </div>
  <div class="card-body">
       <form action="{{route('admin.eCommerce.seo.store')}}" id='content_form' class ='form-validate-jquery' method="post" >
    @csrf
    <input type="hidden" name="row_id" value="{{isset($model)?$model->id:''}}">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
            <label for="meta_title">{{_lang('Meta Title')}}</label>
            <input type="text" required name="meta_title" id="name" class="form-control" value="{{isset($model)?$model->meta_title:''}}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="meta_author">{{_lang('Meta Author')}}</label>
            <input type="text" required name="meta_author" id="meta_author" class="form-control" value="{{isset($model)?$model->meta_author:''}}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="meta_keyword">{{_lang('Meta Keyword')}}</label>
            <input type="text" required name="meta_keyword" data-role="tagsinput" class="form-control" id="meta_keyword"  value="{{isset($model)?$model->meta_keyword:''}}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="meta_description">{{_lang('Meta Desscription')}}</label>
           <textarea class="form-control" cols="3" id="meta_description" name="meta_description" rows="2">{{isset($model)?$model->meta_description:''}}</textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
             <label for="google_analytics">{{_lang('Google Analytics')}}</label>
             <textarea name="google_analytics"  cols="10" rows="10" class='form-control' id="google_analytics">{{isset($model)?$model->google_analytics:''}}</textarea>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
             <label for="bing_analytics">{{_lang('Bing Analytics')}}</label>
             <textarea name="bing_analytics" cols="10" rows="10" class='form-control' id="bing_analytics">{{isset($model)?$model->bing_analytics:''}}</textarea>
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
  $('#meta_keyword').tagsInput();
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