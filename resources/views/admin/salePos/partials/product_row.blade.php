<tr>
	<td>
		<input type="text"  class="form-control" value="{{ $data->product_name}}{{ $data->vari_name }}" readonly>
		<input type="hidden" name="variation[{{ $row }}][product_id]" class="form-control" value="{{ $data->product_id }}">
		<input type="hidden" name="variation[{{ $row }}][variation_id]" class="form-control" value="{{ $data->variation_id }}">
		<input type="hidden" id="brand_id" name="variation[{{ $row }}][brand_id]"  class="code" value="{{$data->brand_id}}" readonly/>
		<input type="hidden" id="code_{{$row}}" data-id="{{$row}}"  class="code" value="{{$data->sku}}" readonly/>
	</td>
	<td>
		<input type="text" class="form-control input_number qty" id="qty_{{$row}}" name="variation[{{ $row }}][quantity]" placeholder="Quantity" value="{{ $quantity }}" required>
		<input type="hidden" class="tqty" value="{{ $sale_type=='wholesale'?$data->qty_available:$data->retail_qty }}">
	</td>
	<td>
		<input type="text" name="variation[{{ $row }}][unit_price]" class="form-control input_number sale_price" value="{{$sale_type=='wholesale'?$data->selling_price:$data->retail_price }}" required>
	</td>
	<td>
		<span class="amt" id="amt_{{$row}}">{{$sale_type=='wholesale'?$data->selling_price:$data->retail_price }}</span>
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm btn_remove">X</button>
	</td> 
</tr>