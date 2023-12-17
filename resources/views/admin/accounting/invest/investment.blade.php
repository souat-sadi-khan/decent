<div class="card">
	<div class="card-body">
		{!! Form::open(['route' => 'admin.accounting.investment.postInvest', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
		<div class="form-group">
			<strong>{{ _lang('Account Name') }}</strong>:
			{{$investment->name}}
			{!! Form::hidden('investment_account_id', $investment->id) !!} 
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					{{ Form::label('amount', _lang('Investment Amount') , ['class' => 'col-form-label']) }}

					{{ Form::text('amount', null, ['class' => 'form-control input_number', 'id'=>'amount', 'placeholder' => _lang('Investment Amount'),'required'=>'','autofocus'=>true]) }}
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

				{{ Form::submit(isset($model) ? _lang('Update'):_lang('Investment'), ['class' => 'btn btn-primary btn-lg w-100 ', 'id' => 'submit']) }}
				<button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
