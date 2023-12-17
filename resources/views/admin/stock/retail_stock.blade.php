<tr>
	<td>
		<i style="cursor:pointer;" class="fa text-danger fa-trash btn_remove" aria-hidden="true"></i>
	</td>
	<td>
		{{ $data->product_name }} {{ $data->vari_name }}
		<input type="hidden" name="variation_id[]" class="form-control" value="{{ $data->variation_id }}">
		<input type="hidden" name="variation_brand_id[]" class="form-control" value="{{ $data->id }}">
		<input type="hidden" name="product_id[]" class="form-control" value="{{ $data->product_id }}">
		<input type="hidden" id="code_{{$row}}" data-id="{{$row}}"  class="code" value="{{$data->sku}}" readonly/>
		<input type="hidden" name="variation[]" class="form-control" value="{{ $data->vari_name }}">
		<input type="hidden" name="product[]" class="form-control" value="{{ $data->product_name }}">
	</td>
	<td>
		{{ $data->qty_available }}
		<input type="hidden" name="avaiable_qty[]" value="{{ $data->qty_available }}">
	</td>
	<td>
		<input type="text" name="stock_qty[]" class="form-control input_number stock_qty" value="0" placeholder="Enter Stock Transfer Quantity" required>

	</td>
</tr>

