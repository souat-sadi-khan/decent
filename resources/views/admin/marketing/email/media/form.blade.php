@php
$route = 'admin.emailmarketing.media.';
@endphp
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Template Media')}}</h6>
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
          {{ Form::label('title', _lang('Title') , ['class' => 'col-form-label']) }}
          {{ Form::text('title', null, ['class' => 'form-control input_number', 'id'=>'title', 'placeholder' => _lang('Title'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('media', _lang('Image Media') , ['class' => 'col-form-label']) }}
        <input type="file" name="path" id="path" class="dropify"
        data-default-file="{{isset($model)?asset('storage/marketing/media/'.$model->path):''}}" />
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