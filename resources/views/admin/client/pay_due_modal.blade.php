<div class="card">
	<div class="card-body">
		<div class="row">
			@if($due_payment_type == 'Purchase')
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Supplier') }}: </strong>{{ $contact_details->name }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Total Purchase') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_purchase }}</span><br>
					<strong>{{ _lang('Total Paid') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_paid }}</span><br>
					<strong>{{ _lang('Total Purchase Due') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_purchase - $contact_details->total_paid }}</span><br>
					@if(!empty($contact_details->opening_balance) || $contact_details->opening_balance != '0.00')
					<strong>{{ _lang('Opening Balance') }}: </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $contact_details->opening_balance }}</span><br>
					<strong>{{ _lang('Opening Balance Due') }}: </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $ob_due }}</span>
					@endif
				</div>
			</div>
			@elseif($due_payment_type == 'purchase_return')
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Supplier') }}: </strong>{{ $contact_details->name }}<
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Total Purchase Return') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_purchase_return }}</span><br>
					<strong>{{ _lang('Purchase Return Paid') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_return_paid }}</span><br>
					<strong>{{ _lang('Purchase Return Due') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_purchase_return - $contact_details->total_return_paid }}</span>
				</div>
			</div>
			@elseif(in_array($due_payment_type, ['Sale']))
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Customer') }}: </strong>{{ $contact_details->name }}<br>
					<strong>{{ _lang('Email') }}: </strong>{{ $contact_details->email }}<br>
					<strong>{{ _lang('Mobile') }}: </strong>{{ $contact_details->mobile }}<br>
					<br><br>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Total Sale') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_invoice }}</span><br>
					<strong>{{ _lang('Total Paid') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_paid }}</span><br>
					<strong>{{ _lang('Total Sale Due') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_invoice - $contact_details->total_paid }}</span><br>
					@if(!empty($contact_details->opening_balance) || $contact_details->opening_balance != '0.00')
					<strong>{{ _lang('Opening Balance') }}: </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $contact_details->opening_balance }}</span><br>
					<strong>{{ _lang("Opening Balance Due") }}: </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $ob_due }}</span>
					@endif
				</div>
			</div>
			@elseif(in_array($due_payment_type, ['sale_return']))
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Customer') }}: </strong>{{ $contact_details->name }}<br>
					<br><br>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>{{ _lang('Total Sale Return') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sell_return }}</span><br>
					<strong>{{ _lang('Sale Return Paid') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_return_paid }}</span><br>
					<strong>{{ _lang('Sale Return Due') }}: </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sell_return - $contact_details->total_return_paid }}</span>
				</div>
			</div>
			@endif
		</div>
		<form action="{{route('admin.client_pay_due_post')}}" method="post" enctype="multipart/form-data" id="content_form">
			<input type="hidden" name="client_id" value="{{ $contact_details->client_id }}">
			<input type="hidden" name="due_payment_type" value="{{ $due_payment_type }}">
			<input type="hidden" name="hidden_amount" value="{{ $payment_line->amount }}">
			<input type="hidden" name="type" value="{{ $type }}">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="amount">{{_lang('Amount')}}</label>
						
						<input type="text" class="form-control" name="amount" id="amount" data-rule-max-value="{{ $payment_line->amount }}" value="{{ $payment_line->amount }}" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="payment_date">{{_lang('Payment Date')}}</label>
						
						<input type="text" class="form-control date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="method">{{_lang('Payment Method')}}</label>
						
						<select class="form-control payment_types_dropdown" id="method"
							name="method">
							<option value="cash">Cash</option>
							<option value="card">Card</option>
							<option value="cheque">Cheque</option>
							<option value="bank_transfer">Bank Transfer</option>
							<option value="other">Other</option>
							<option value="custom_pay_1">Custom Payment 1</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="transaction">Transaction No.</label>
						<input class="form-control" placeholder="Transaction No." id="transaction" name="transaction_no" type="text" value="">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="note_0">Payment note:</label>
						<textarea class="form-control" rows="3" id="note_0" name="note" cols="50"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mx-auto text-center">
					<input type="submit" class="btn btn-primary btn-lg w-100" id="submit" value="Paid">
					<button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
				</div>
			</div>
		</form>
	</div>
</div>