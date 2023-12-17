<div class="card">
	<div class="card-header">
		<h6>{{ _lang('Send Email') }}</h6>
	</div>
	<div class="card-body">
		{!! Form::open(['route' => 'admin.emailmarketing.client_send_mail', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('email', _lang('Email') , ['class' => 'col-form-label']) }}
					{{ Form::text('email', $model->email?$model->email:null, ['class' => 'form-control', 'id'=>'email', 'placeholder' => _lang('Email'),'required'=>'','readonly'=>'']) }}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('template', _lang('Email Template') , ['class' => 'col-form-label']) }}
					{!! Form::select('template', $templates, 'template', [ 'class'=>'form-control select', 'placeholder' => 'Pick Template','required'=>''])!!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('subject', _lang('Subject') , ['class' => 'col-form-label']) }}
					
					{!! Form::text('subject',null, ['id' => 'subject', 'class' =>'form-control ','required'=>'']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mx-auto text-center">
				
				{{ Form::submit( _lang('Send Mail'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>