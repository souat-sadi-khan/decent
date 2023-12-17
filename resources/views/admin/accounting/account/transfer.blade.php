<div class="card">
	<div class="card-body">
		{!! Form::open(['route' => 'admin.accounting.account.postFundtransfer', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<div class="form-group">
			<strong>{{ _lang('Selected Account') }}</strong>:
			    {{$from_account->name}}
                {!! Form::hidden('from_account', $from_account->id) !!}
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('to_account', _lang('To Account') , ['class' => 'col-form-label']) }}
					{!! Form::select('to_account', $to_accounts, null, ['class' => 'form-control select', 'required' ]); !!}
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
					{{ Form::label('operation_date', _lang('Date') , ['class' => 'col-form-label']) }}
					{{ Form::text('operation_date', date('Y-m-d'), ['class' => 'form-control date', 'id'=>'operation_date', 'placeholder' => _lang('Date'),'required'=>'','autofocus'=>true]) }}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					{!! Form::label('note', _lang( 'Note' )) !!}
					{!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => _lang( 'Note' ), 'rows' => 4]); !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mx-auto text-center">
				
				{{ Form::submit(isset($model) ? _lang('Update'):_lang('Transfer'), ['class' => 'btn btn-primary btn-sm w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>