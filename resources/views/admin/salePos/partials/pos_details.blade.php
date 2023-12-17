<div class="mt-3" style="background-color: #eaeaea;">
	<div class="card-body p-0">
		<table class="table table-bordered border-dark" style="margin-bottom: 0px !important">
			<tbody>
				<tr>
					<td>
						<span>{{ _lang('Total Item') }}</span> <br>
						<input type="hidden" class="total_item">
						<span class="total_item">0</span>
					</td>
					<td>
						<span>{{ _lang('Total') }}</span> <br>
						<input type="hidden" name="sub_total" class="sub_total">
						<span class="sub_total">0</span>
					</td>
					<td style="width: 40%">
						<span>{{ _lang('Discount Type') }}</span> <br>
						<select name="discount_type" class="form-control" id="discount_type">
							<option value="">None</option>
							<option value="percentage">Percentage</option>
							<option value="fixed">Fixed</option>
						</select>
					</td>
					<td>
						<span>{{ _lang('Discount') }}</span> <br>
						<input type="text" name="discount" class="form-control input_number" id="discount_amount">
					</td>
				</tr>
				<tr>
					<td>
						<span>{{ _lang('Discount Value') }}</span> <br>
						<input type="text" name="discount_amount" class="form-control" id="total_discount" readonly>
					</td>
					<td>
						<span>{{ _lang('Tax') }}</span> <br>
						<input type="text" name="tax" class="form-control input_number" id="tax_calculation_amount">
						<input type="hidden" name="tax_amount" class="form-control input_number" id="tax_amount">
					</td>
					<td>
						<span>{{ _lang('Shipping') }}</span> <br>
						<input type="text" name="shipping_charges" class="form-control input_number" id="shipping_charges">
					</td>
					<td>
						<span>{{ _lang('Total Payable') }}</span> <br>
						<input type="hidden" class="form-control net_total" name="net_total">
						<span class="net_total"></span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<button type="button" class="btn btn-success btn-block" id="payment_modal">Pay amount</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>