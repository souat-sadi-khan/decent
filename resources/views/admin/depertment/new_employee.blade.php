<div class="card">
	<div class="card-header">
		<h6> {{_lang('New Employee')}}</h6>
	</div>
	<div class="card-body">
		{!! Form::open(['route' => 'admin.depertment_new_employee_add', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<input type="hidden" name="depertment_id" value="{{ $depert->id }}">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('employee_id', _lang('Employee') , ['class' => 'col-form-label']) }}
					{!! Form::select('employee_id', $employee, null, [ 'class'=>'form-control select', 'placeholder' => 'Select Employee','required'=>''])!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mx-auto text-center">
				
				{{ Form::submit(_lang('Create'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>