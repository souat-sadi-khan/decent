<div class="card">
	<div class="card-header">
		<h6>{{ _lang('Send Sms') }}</h6>
	</div>
	<div class="card-body">
		{!! Form::open(['route' =>'admin.smsmerketing.client_send_sms', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('mobile', _lang('Mobile') , ['class' => 'col-form-label']) }}
					{{ Form::text('mobile', $model->phone, ['class' => 'form-control', 'id'=>'mobile', 'placeholder' => _lang('Mobile'),'required'=>'','readonly'=>'']) }}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('message', _lang('Message') , ['class' => 'col-form-label']) }}
					
					  {!! Form::textarea('message',null, ['id' => 'message', 'class' =>'form-control ','required'=>'','placeholder'=>'Message']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mx-auto text-center">
				
				{{ Form::submit( _lang('Send Sms'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>