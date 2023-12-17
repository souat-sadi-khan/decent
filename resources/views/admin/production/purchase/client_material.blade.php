@foreach ($model as $item)
    @php
   if($wop_qty){
     $qty = $wop_qty->where('raw_material_id', $item->raw_material_id)->sum('qty');
} else{
    $qty = 1;
}
    @endphp
	   <tr>
	<td>
    <input type="hidden" name="raw_material[]" value="{{$item->raw_material_id}}" class="pid">
    {{ $item->raw->name }}
	</td>
	<td>
        <input type="text" class="form-control input_number qty" id="qty" name="qty[]"
            value="{{ $qty }}">
    </td>
	<td>
        <input type="hidden" class="form-control" name="unit_id[]" value="{{ $item->raw->unit->id }}">
        {{ $item->raw->unit->unit }}
        @if ($item->raw->unit->child_unit)
            / {{$item->raw->unit->child_unit}}
        @endif
	</td>
	<td>
        <input type="text" class="form-control input_number unit_price" id="unit_price" name="unit_price[]" value="{{ $item->raw->price }}">
    </td>
    <td>
        <input type="text" class="form-control input_number price" id="price" readonly name="price[]"
            value="{{ $item->raw->price * $qty }}">
    </td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr>
@endforeach
