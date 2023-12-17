@php
$route = 'admin.emailmarketing.template.';
@endphp
@extends('layouts.app', ['title' => _lang('Send Sms'),'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')

<style>

.nav-pills .nav-link {
    border-radius: 0.25rem;
    background-color: #e4e2e2;
    margin: 0px 6px;
}
</style>
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="SendSms."><i class="fa fa-universal-access mr-4"></i>
    {{_lang('Send Sms')}}</h1>
    <p>{{_lang('Send Sms.')}}</p>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<div class="card">
  <div class="card-body">
    <ul class="nav nav-pills nav-justified" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#sendmail">{{ _lang('Send Sms') }}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#groupmail">{{ _lang('Send Sms By Group') }}</a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="sendmail" class="container tab-pane active"><br>
        {!! Form::open(['route' =>'admin.smsmerketing.sendsms.store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ _lang('Compose Sms') }}</h5>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('numbers', _lang('Numbers') , ['class' => 'col-form-label']) }}
                      {!! Form::textarea('numbers',null, ['id' => 'numbers', 'class' =>'form-control ','required'=>'','placeholder'=>'Phone Number separated by comma']) !!}
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('message', _lang('Message') , ['class' => 'col-form-label']) }}
                      
                       {!! Form::textarea('message',null, ['id' => 'message', 'class' =>'form-control ','required'=>'','placeholder'=>'Message']) !!}
                    </div>
                  </div>
                  <input type="hidden" name="sms_identifier" value="sms_number">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="form-group col-md-12" align="right">
          <button type="submit" class="btn btn-primary py-2" id="">{{_lang('Send')}}<i class="fa fa-envelope-o px-1" aria-hidden="true"></i></button>
          <button type="button" class="btn btn-info" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
      </div>
      {!! Form::close() !!}
        
      </div>
      <div id="groupmail" class="container tab-pane fade"><br>
        {!! Form::open(['route' =>'admin.smsmerketing.sendsms.store', 'class' => 'form-validate-jquery ajax_form', 'id' => '', 'files' => true, 'method' => 'POST']) !!}
        <input type="hidden" name="sms_identifier" value="group">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ _lang('Compose Sms') }}</h5>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('user_type', _lang('Customer Type') , ['class' => 'col-form-label']) }}
                      {!! Form::select('user_type', ['wholesale'=>'Wholesale','brand'=>'Parmanent'], 'user_type', [ 'class'=>'form-control select2', 'placeholder' => 'Customer Type','required'=>''])!!}
                    </div>
                  </div>
                  <div class="col-md-12 wholesale-group" style="display: none;">
                    <div class="form-group">
                      <label class="control-label">{{ _lang('Select Client') }}</label>
                      <select name="client_id" id="client_id" onchange="get_all_client();" class="form-control select2">
                        <option value="">{{ _lang('Select One') }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12 general-group" style="display: none;">
                    <div class="form-group">
                      <label class="control-label">{{ _lang('Select Receiver') }}</label>
                      <select name="brand_id" id="brand_id" onchange="get_all_brand();" class="form-control select2">
                        <option value="">{{ _lang('Select One') }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      {{ Form::label('message', _lang('Message') , ['class' => 'col-form-label']) }}
                      
                       {!! Form::textarea('message',null, ['id' => 'message', 'class' =>'form-control ','required'=>'','placeholder'=>'Message']) !!}
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-heading">{{ _lang('User List') }}</div>
              <div class="card-body" id="user_list" style="max-height: 500px;overflow-y: scroll;">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group col-md-12" align="right">
            <button type="submit" class="btn btn-primary btn-lg p-2" id="submit">{{_lang('Send')}}<i class="fa fa-envelope-o px-1" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    $('.select2').select2({width:'100%'});
    $(document).on('change','#user_type',function(){
    var user_type = $(this).val();
    
    if( user_type == "wholesale" ){
      $(".wholesale-group").fadeIn();
      $(".general-group").css("display","none");
      $("#client_id").prop("required",true);
      $("#brand_id").prop("required",false);
      getclient('wholesale');
    }else{
      $(".wholesale-group").css("display","none");
      $(".general-group").fadeIn();
      $("#client_id").prop("required",false);
      $("#brand_id").prop("required",true);
      getbrand(user_type);
    }
  });

    function getclient( type ) {
    $.ajax({
      url: "{{ url('admin/smsmerketing/get_number') }}/"+type,
      beforeSend: function(){
          $("#preloader").css("display","block");
      },success: function(data){
        $("#preloader").css("display","none");
        var json =JSON.parse(data);
          $('select[name=client_id]').html("");
          $('#user_list').html(""); 
             
        jQuery.each( json, function( i, val ) {
          $('select[name=client_id]').append("<option value='"+val['mobile']+"'>"+val['name']+"</option>");
        });

        if( $('#client_id').has('option').length > 0 ) {
          $('select[name=client_id]').prepend("<option value='all'>All "+type+"</option>");
        }       
      }
    });
  }

   function getbrand(type ) {
    $.ajax({
      url: "{{ url('admin/smsmerketing/get_number') }}/"+type,
      beforeSend: function(){
          $("#preloader").css("display","block");
      },success: function(data){
        $("#preloader").css("display","none");
        var json =JSON.parse(data);
          $('select[name=brand_id]').html("");
        $('#user_list').html(""); 
             
        jQuery.each( json, function( i, val ) {
          $('select[name=brand_id]').append("<option value='"+val['phone']+"'>"+val['name']+"</option>");
        });

        if( $('#brand_id').has('option').length > 0 ) {
          $('select[name=brand_id]').prepend("<option value='all'>All "+type+"</option>");
        }       
      }
    });
  }

    function get_all_client(){
    if($("#client_id").val() == "all"){    
      var user_type = "/"+$('select[name=user_type]').val();
      var link = "{{ url('admin/smsmerketing/get_number_list') }}"+user_type;
      $.ajax({
        url: link,
        beforeSend: function(){
          $("#preloader").css("display","block");
        },success: function(data){
          $("#preloader").css("display","none");
          var json =JSON.parse(data);
          $('#user_list').html(""); 
          
          jQuery.each( json, function( i, val ) {
             $('#user_list')
             .append('<div class="col-md-12"><div class="animated-checkbox"><label><input type="checkbox" name="client[]" value="'+val['mobile']+'" checked="true"><span class="label-text">'+val['name']+"-"+val['mobile']+'</span></label></div></div>');
          });
  
        }
      });
    }else{
      $('#user_list').html("");
    }
  }

    function get_all_brand(){
    if($("#brand_id").val() == "all"){    
      var user_type = "/"+$('select[name=user_type]').val();
      var link = "{{ url('admin/emailmarketing/get_emails_list') }}"+user_type;
      $.ajax({
        url: link,
        beforeSend: function(){
          $("#preloader").css("display","block");
        },success: function(data){
          $("#preloader").css("display","none");
          var json =JSON.parse(data);
          $('#user_list').html(""); 
          
          jQuery.each( json, function( i, val ) {
             $('#user_list')
             .append('<div class="col-md-12"><div class="animated-checkbox"><label><input type="checkbox" name="brand[]" value="'+val['phone']+'" checked="true"><span class="label-text">'+val['name']+"-"+val['phone']+'</span></label></div></div>');
          });
  
        }
      });
    }else{
      $('#user_list').html("");
    }
  }
_formValidation();
_classformValidation();
</script>
@endpush