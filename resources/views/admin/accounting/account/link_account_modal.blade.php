<div class="card">
	<div class="card-body">
		{!! Form::open(['route' => 'admin.accounting.postLinkAccount', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{!! Form::hidden('transaction_payment_id', $payment->id); !!}
					{!! Form::label('account_id',_lang('Account') .":") !!}
					{!! Form::select('account_id', $accounts, $payment->account_id, ['class' => 'form-control select', 'required']); !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 mx-auto text-center">
				
				{{ Form::submit(isset($model) ? _lang('Update'):_lang('Link Account'), ['class' => 'btn btn-primary btn-sm w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>