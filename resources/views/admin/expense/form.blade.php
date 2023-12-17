@php
$route = 'admin.expense.ex.';
@endphp
<div class="card">
  <div class="card-header">
    <h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Expense')}}</h6>
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
          {{ Form::label('investment_account_id', _lang('Investment Account') , ['class' => 'col-form-label']) }}
          {!! Form::select('investment_account_id', $investment, null, ['class' => 'form-control select', 'required' ]); !!}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('expense_category_id', _lang('Expense Category') , ['class' => 'col-form-label required']) }}
          <select name="expense_category_id" id="expense_category_id" class="form-control select" >
            <option value="">Select</option>
            @foreach ($categories as $category)
            <option {{ isset($model)?$model->expense_category_id==$category->id?'selected':'':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('employee_id', _lang('Expense For') , ['class' => 'col-form-label']) }}
             <select name="employee_id" id="employee_id" class="form-control select" >
            <option value="">None</option>
            @foreach ($employeis as $employee)
            <option {{ isset($model)?$model->employee_id==$employee->id?'selected':'':'' }} value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('amount', _lang('Amount') , ['class' => 'col-form-label']) }}
          {{ Form::text('amount', null, ['class' => 'form-control input_number', 'id'=>'amount', 'placeholder' => _lang('Amount'),'required'=>'','autofocus'=>true]) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('reson', _lang('Reason') , ['class' => 'col-form-label']) }}
          {{ Form::text('reson', null, ['class' => 'form-control', 'id'=>'reson', 'placeholder' => _lang('Reason'),'required'=>'','autofocus'=>true]) }}
          <span id="reson_error"></span>
        </div>
      </div>
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
        <button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>

      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
