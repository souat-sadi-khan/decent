<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header bg-light border-grey-300">
			<h5 class="modal-title"></h5>
			<button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			@php
			$route = 'admin.client.';
			@endphp
			<div class="card">
				<div class="card-header">
					<h6></h6>
				</div>
				<div class="card-body">
					{!! Form::open(['route' => $route.'quick_add', 'class' => 'form-validate-jquery quick_add_contact', 'id' => 'remort_add', 'files' => true, 'method' => 'POST']) !!}
					<input type="hidden" name="type" value="customer">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('sub_type', _lang('Client Type').':') !!}
								{!! Form::select('sub_type', ['retail'=>'Retail','wholesale'=>'WholeSale','ecommerce'=>'eCommerce'], null, ['class' => 'form-control','id'=>'sub_type']); !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('name', _lang('Name') , ['class' => 'col-form-label']) }}
								{{ Form::text('name', null, ['class' => 'form-control ', 'id'=>'name', 'placeholder' => _lang('Name'),'required'=>'','autofocus'=>true]) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{{ Form::label('email', _lang('Email') , ['class' => 'col-form-label']) }}
								{{ Form::text('email', null, ['class' => 'form-control ', 'id'=>'email', 'placeholder' => _lang('Email')]) }}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{{ Form::label('mobile', _lang('Mobile') , ['class' => 'col-form-label']) }}
								{{ Form::text('mobile', null, ['class' => 'form-control ', 'id'=>'mobile', 'placeholder' => _lang('Mobile'),'required'=>'','autofocus'=>true]) }}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{{ Form::label('alternate_number', _lang('Alternate Mobile') , ['class' => 'col-form-label']) }}
								{{ Form::text('alternate_number', null, ['class' => 'form-control ', 'id'=>'alternate_number', 'placeholder' => _lang('Alternate Mobile')]) }}
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
								{{ Form::text('net_total', null, ['class' => 'form-control', 'id'=>'net_total', 'placeholder' => _lang('Opening Balance')]) }}
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
							
							{{ Form::submit(isset($model) ? _lang('Update'):_lang('Create'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
							<button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>