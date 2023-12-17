@php
$route = 'admin.department.';
@endphp
<div class="card">
	<div class="card-header">
		<h6>{{ isset($model) ? _lang('Update'):_lang('Create') }} {{_lang('Department')}}</h6>
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
					{{ Form::label('name', _lang('Department Name') , ['class' => 'col-form-label']) }}
					{{ Form::text('name', null, ['class' => 'form-control', 'id'=>'name', 'placeholder' => _lang('Department Name'),'required'=>'']) }}
				</div>
			</div>
			@if (!isset($model))
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('employee_id', _lang('Employee') , ['class' => 'col-form-label']) }}
					{!! Form::select('employee_id', $employee, null, [ 'class'=>'form-control select', 'placeholder' => 'Select Employee','required'=>''])!!}
				</div>
			</div>
			@endif
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('description', _lang('Description') , ['class' => 'col-form-label']) }}
					
					{!! Form::textarea('description',null, ['id' => 'description', 'class' =>'form-control ','placeholder'=>'Description']) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('flow', _lang('Order Sequence') , ['class' => 'col-form-label']) }}
					<select name="flow" class="form-control select">
						<option value="">Select Order</option>
						<option {{ isset($model)?$model->flow=='First'?'selected':'':'' }} value="First">First Order</option>
						<option {{ isset($model)?$model->flow=='last'?'selected':'':'' }} value="last">Last Order</option>
					</select>
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