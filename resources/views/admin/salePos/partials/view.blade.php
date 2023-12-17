<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="modalTitle"> {{ _lang('Sell Details') }} (<b>{{ _lang('Invoice No') }}.:</b> {{ $model->reference_no }})
		</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 text-right">
				<p class="float-right"><b>{{ _lang('Date') }}:</b> {{ $model->date }}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<b>{{ _lang('Invoice No') }}.:</b> {{ $model->reference_no }}<br>
				<b>{{ _lang('Payment status') }}:</b> {{ $model->payment_status }}<br>
			</div>
			<div class="col-sm-6">
				<b>{{ _lang('Customer name') }}:</b>{{ $model->client->name}}<br>
				<b>{{ _lang('Phone') }}: {{ $model->client->mobile }}</b><br>
				
				
				<br>
				
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h4>{{ _lang('Products') }}:</h4>
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table class="table bg-gray">
						<tbody><tr class="bg-green text-light">
							<th>#</th>
							<th>{{ _lang('Product') }}</th>
							<th>{{ _lang('Quantity') }}</th>
							<th>{{ _lang('Unit Price') }}</th>
							<th>{{ _lang('Subtotal') }}</th>
						</tr>
						@foreach ($model->sell_lines as $product)
						<tr>
							<td>{{ $loop->index+1 }}</td>
							<td>{{ $product->product->name }}-{{$product->variation->name}}</td>
							@can('view_sale.qty')
							<td>{{ $product->quantity }}</td>
							@endcan
							@can('view_sale.sale_price')
							<td>{{ $product->unit_price }}</td>
							<td>{{ $product->total }}</td>
							@endcan
						</tr>
						@endforeach
					</tbody>
				</table>  

				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<h4>{{ _lang('Payment info') }}:</h4>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="table-responsive">
					 <table class="table bg-gray">
						<tbody>
							<tr class="bg-green text-light">
								<th>#</th>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Reference No') }}</th>
								@can('view_sale.sale_paid')
								<th>{{ _lang('Amount') }}</th>
								@endcan
								<th>{{ _lang('Payment mode') }}</th>
								<th>{{ _lang('Payment note') }}</th>
							</tr>
							@foreach ($model->payment as $pay)
							<tr>
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $pay->payment_date }}</td>
								<td>{{ $pay->transaction_no }}</td>
								@can('view_sale.sale_paid')
								<td>{{ $pay->amount }}</td>
								@endcan
								<td>{{ $pay->method }}</td>
								<td>{{ $pay->note }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				  </div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table bg-gray">
							<tbody>
							@can('view_sale.sale_price')
							<tr>
								<th>{{ _lang('Total') }}: </th>
								<td></td>
								<td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->sub_total }}</span></td>
							</tr>
							@endcan
							@can('view_sale.sale_discount')
							<tr>
								<th>{{ _lang('Discount') }}:</th>
								<td><b>(-)</b></td>
								<td><span class="pull-right">{{ $model->discount_amount }} </span></td>
							</tr>
							@endcan
							@can('view_sale.sale_tax')
							<tr>
								<th>{{ _lang('Tax') }}:</th>
								<td><b>(+)</b></td>
								<td class="text-right">
									{{ $model->tax }}
								</td>
							</tr>
							@endcan
							@can('view_sale.shipping_charge')
							<tr>
								<th>{{ _lang('Shipping') }}: </th>
								<td><b>(+)</b></td>
								<td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->shipping_charges }}</span></td>
							</tr>
							@endcan
							@can('view_sale.sale_price')
							<tr>
								<th>{{ _lang('Total Payable') }}: </th>
								<td></td>
								<td><span class="display_currency pull-right">{{ $model->net_total }}</span></td>
							</tr>
							@endcan
							@can('view_sale.sale_paid')
							<tr>
								<th>{{ _lang('Total paid') }}:</th>
								<td></td>
								<td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->paid }}</span></td>
							</tr>
							@endcan
							@can('view_sale.sale_due')
							<tr>
								<th>{{ _lang('Total remaining') }}:</th>
								<td></td>
								<td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->due }}</span></td>
							</tr>
							@endcan
						</tbody>
					</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<strong>{{ _lang('Sell note') }}:</strong><br>
					<p class="well well-sm no-shadow bg-gray p-2">
						{{ $model->sale_note }}
					</p>
				</div>
				<div class="col-sm-6">
					<strong>{{ _lang('Staff note') }}:</strong><br>
					<p class="well well-sm no-shadow bg-gray p-2">
						{{ $model->stuff_note }}
					</p>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="print-invoice btn btn-primary" data-href="http://erp.sattit.com/sells/195/print"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
			<button type="button" class="btn btn-default no-print" data-dismiss="modal">Close</button>
		</div>
	</div>