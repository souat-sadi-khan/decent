@php
$route = 'admin.accounting.investment.';
@endphp
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Account')}}</h6>
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
          {{ Form::label('name', _lang('Investment Account Name') , ['class' => 'col-form-label']) }}
          {{ Form::text('name', null, ['class' => 'form-control', 'id'=>'name', 'placeholder' => _lang('Investment Account Name'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('account_number', _lang('Account No') , ['class' => 'col-form-label']) }}
          {{ Form::text('account_number', null, ['class' => 'form-control', 'id'=>'account_number', 'placeholder' => _lang('Account No'),'required'=>'']) }}
        </div>
      </div>

      @if (!isset($model))
        <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('opening_balance', _lang('Opening Investment') , ['class' => 'col-form-label']) }}
          {{ Form::text('opening_balance', null, ['class' => 'form-control input_number', 'id'=>'opening_balance', 'placeholder' => _lang('Opening Investment')]) }}
        </div>
      </div>
      @endif
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('note', _lang('Note') , ['class' => 'col-form-label']) }}
          {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' =>  _lang('Note'), 'rows' => '5']) }}
          <span id="note_error"></span>
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