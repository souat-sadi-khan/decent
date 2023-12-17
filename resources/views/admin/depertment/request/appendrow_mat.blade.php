@foreach ($models as $item)
<tr>
	<td>
		<input type="hidden" name="raw_material_id[]" class="raw_material_id" value="{{ $item->id }}">
		{{ $item->name }})
	</td>
	<td></td>
	<td>
		<div class="input-group mb-3">
			<input type="text" class="form-control input_number qty qty_{{$item->id}}" id="{{$item->id}}" name="qty[]" value="" required>
			<div class="input-group-append">
				<span class="input-group-text">{{ $item->unit->unit }}</span>
			</div>
		</div>
		
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr>
@endforeach