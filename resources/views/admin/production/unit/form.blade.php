@php
$route = 'admin.production-unit.';
@endphp
<div class="card">
  <div class="card-header">
    <h6>{{_lang('Add New Production Unit')}}</h6>
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
          {{ Form::label('unit', _lang('Unit') , ['class' => 'col-form-label required']) }}
          {{ Form::text('unit', null, ['class' => 'form-control', 'id'=>'unit', 'placeholder' => _lang('Unit'),'required'=>'']) }}
        </div>
      </div>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input sub_unit_check" id="sub_unit_check" name="check" {{ isset($model)?$model->child_unit?'checked':'':'' }} value="1">
        <label class="custom-control-label" for="sub_unit_check">{{_lang('Unit has Subunit')}}</label>
      </div>
    </div>
    <div class="row sub_unit_form" style="{{ isset($model)?$model->child_unit?'display: block;':'display: none;':'display: none;' }}">
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('child_unit', _lang('Child Unit') , ['class' => 'col-form-label']) }}
          {{ Form::text('child_unit', null, ['class' => 'form-control', 'id'=>'child_unit', 'placeholder' => _lang('Child Unit')]) }}
        </div>
        
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="" class="control-label">Unit Convert <span class="text-danger">*</span> </label>
          <div class="row">
            <div class="col-md-6">
              1 <span id="print_unit">{{ isset($model)?$model->unit:'Unit' }}</span> =
              {{ Form::text('convert_rate', null, ['class' => 'form-control', 'id'=>'convert_rate','placeholder' => _lang('Child Unit')]) }}
            </div>
            <div class="col-md-6">
              ? <br>
              <label for="" class=" control-label" id="print_child_unit"> {{ isset($model)?$model->child_unit:'Child Unit' }} </label>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mx-auto text-center">
        
        {{ Form::submit(isset($model) ? _lang('Update'):_lang('Create'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
        <button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>