<form action="{{ route('admin.post_product_status') }}" method="post" id="content_form">
	<table class="table">
		<thead>
			<tr>
				<th>{{ _lang('Product') }}</th>
				<th>{{ _lang('Variation') }}</th>
				<th>{{ _lang('Purchase Price') }}</th>
				<th>{{ _lang('WholeSale Price') }}</th>
				<th>{{ _lang('Retail Price') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($model->variation as $element)
			<tr>
				<td>{{ $element->product->name }}</td>
				<td>{{ $element->name }}</td>
				<td>
					<input type="hidden" name="variation_id[] " value="{{ $element->id }}" />
					<input type="text" name="default_purchase_price[]" class="form-control input_number" value="{{ $element->default_purchase_price }}" />
				</td>
				<td>
					<input type="text" name="default_sell_price[]" class="form-control input_number"  value="{{ $element->default_sell_price }}" />
				</td>
				<td>
					<input type="text" name="retail_sell_price[]" class="form-control input_number" value="{{ $element->retail_sell_price }}">
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="hidden" name="status" value="Production">
	<input type="hidden" name="product_id" value="{{ $model->id }}">
	<div class="form-group col-md-12" align="center">
		{{-- <input type="hidden" name="type[]" value=" "> --}}
		<button type="submit" class="btn btn-primary" id="submit">{{_lang('Update and Submit')}}<i
		class="icon-arrow-right14 position-right"></i></button>
		<button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
		<i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
	</div>
</form>