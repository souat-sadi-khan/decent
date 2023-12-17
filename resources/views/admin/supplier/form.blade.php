@php
$route = 'admin.client.';
@endphp
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Supplier')}}</h6>
  </div>
  <div class="card-body">
    @if(isset($model))
    {!! Form::model($model, ['route' => [$route.'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
    @else
    {!! Form::open(['route' => $route.'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
    @endif
    <input type="hidden" name="type" value="supplier">
    <input type="hidden" name="trans_type" value="Debit">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('name', _lang('Name') , ['class' => 'col-form-label']) }}
          {{ Form::text('name', null, ['class' => 'form-control', 'id'=>'name', 'placeholder' => _lang('Name'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('email', _lang('Email') , ['class' => 'col-form-label']) }}
          {{ Form::text('email', null, ['class' => 'form-control', 'id'=>'email', 'placeholder' => _lang('Email')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('mobile', _lang('Mobile') , ['class' => 'col-form-label']) }}
          {{ Form::text('mobile', null, ['class' => 'form-control', 'id'=>'mobile', 'placeholder' => _lang('Mobile'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('alternate_number', _lang('Alternate Mobile') , ['class' => 'col-form-label']) }}
          {{ Form::text('alternate_number', null, ['class' => 'form-control', 'id'=>'alternate_number', 'placeholder' => _lang('Alternate Mobile')]) }}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('country', _lang('Country') , ['class' => 'col-form-label']) }}
          {{ Form::text('country', 'Bangladesh', ['class' => 'form-control', 'id'=>'country', 'placeholder' => _lang('Country'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('state', _lang('State') , ['class' => 'col-form-label']) }}
          {{ Form::text('state', null, ['class' => 'form-control', 'id'=>'state', 'placeholder' => _lang('State')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('city', _lang('City') , ['class' => 'col-form-label']) }}
          {{ Form::text('city', null, ['class' => 'form-control', 'id'=>'city', 'placeholder' => _lang('City')]) }}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('landmark', _lang('Landmark') , ['class' => 'col-form-label']) }}
          {{ Form::text('landmark', null, ['class' => 'form-control', 'id'=>'landmark', 'placeholder' => _lang('Landmark')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('landline', _lang('Landline') , ['class' => 'col-form-label']) }}
          {{ Form::text('landline', null, ['class' => 'form-control', 'id'=>'landline', 'placeholder' => _lang('Landline')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('net_total', _lang('Opening Balance') , ['class' => 'col-form-label']) }}
          {{ Form::text('net_total', isset($opening_balance)?$opening_balance:null, ['class' => 'form-control input_number', 'id'=>'net_total', 'placeholder' => _lang('Opening Balance')]) }}
        </div>
      </div>
    </div>
    <h5>{{ _lang('Banking Info') }}</h5>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('bank_name', _lang('Bank Name') , ['class' => 'col-form-label']) }}
          {{ Form::text('bank_name', null, ['class' => 'form-control', 'id'=>'bank_name', 'placeholder' => _lang('Bank Name')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('account_name', _lang('Bank Account') , ['class' => 'col-form-label']) }}
          {{ Form::text('account_name', null, ['class' => 'form-control', 'id'=>'account_name', 'placeholder' => _lang('Bank Account')]) }}
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{ Form::label('bank_holder', _lang('Bank Holder') , ['class' => 'col-form-label']) }}
          {{ Form::text('bank_holder', null, ['class' => 'form-control', 'id'=>'bank_holder', 'placeholder' => _lang('Bank Holder')]) }}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mx-auto text-center">
        
        {{ Form::submit(isset($model) ? _lang('Update'):_lang('Create'), ['class' => 'btn btn-primary btn-sm w-100 ', 'id' => 'submit']) }}
        <button type="button" class="btn btn-primary btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>