@foreach ($models->wop_material as $item)
    <tr>
	<td>
        <input type="hidden" name="raw_material[]" value="{{ $item->raw_material_id }}" class="pid">
        <input type="hidden" name="product_id[]" value="{{ $item->work_order_product->product->id }}">
		{{ $item->work_order_product->product->name }}({{ $item->raw_material->name }})
	</td>
	<td>
        <input type="text" class="form-control input_number qty" id="qty" name="qty[]"
            value="{{ $item->qty }}">
    </td>
	<td>
        <input type="hidden" class="form-control" name="unit_id[]" value="{{ $item->raw_material->unit->id }}">{{ $item->raw_material->unit->unit }}
        @if ($item->raw_material->unit->child_unit)
            / {{$item->raw_material->unit->child_unit}}
        @endif
	</td>
	<td>
        <input type="text" class="form-control input_number unit_price" id="unit_price" name="unit_price[]" value="{{ $item->unit_price }}">
    </td>
    <td>
        <input type="text" class="form-control price" id="price" readonly name="price[]"
            value="{{ $item->price }}">
    </td>
    {{-- <td>
        <input type="text" class="form-control input_number waste" maxlength="2" id="waste" name="waste[]"
            value="{{ $item->waste }}">
    </td>
    <td>
        <input type="text" readonly class="form-control uses" id="uses" name="uses[]"
            value="{{ $item->uses }}">
    </td> --}}
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove">X</button>
	</td>
</tr>
@endforeach