<tr>
	<td>
		<input type="hidden" name="raw_material[]" value="{{ $model->id }}" class="pid">
		{{ $model->name }}
	</td>
	<td>
		<input type="hidden" name="qty[]" value="{{ $quantity }}" class="qty">
		<input type="hidden" name="uses[]" value="{{ $uses }}">
		<input type="hidden" name="waste[]" value="{{ $waste }}">
		<input type="hidden" name="price[]" value="{{ $Price }}">
		<input type="hidden" name="unit_price[]" value="{{ $unit_price }}">
		<input type="hidden" name="raw_status[]" value="{{ $status }}">
		<input type="hidden" name="unit[]" value="{{ $unit }}">
		<input type="hidden" name="raw_description[]" value="{{ $description }}">
		{{ $quantity }} <small> {{ $unit_name }}</small>
	</td>
{{-- 	<td>
		<input type="hidden" name="unit_price[]" value="{{ $unit_price }}">
		{{ $unit_price }}
	</td>
	<td>
		<input type="hidden" name="price[]" value="{{ $Price }}">
		{{ $Price }}
	</td>
	<td>
		<input type="hidden" name="waste[]" value="{{ $waste }}">
		{{ $waste }}
	</td>
	<td>
		<input type="hidden" name="uses[]" value="{{ $uses }}">
		{{ $uses }}
	</td>
	<td>
		<input type="hidden" name="raw_status[]" value="{{ $status }}">
		<input type="hidden" name="unit[]" value="{{ $unit }}">
		<input type="hidden" name="raw_description[]" value="{{ $description }}">
		{{ $status }}
	</td> --}}
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
	</td>
</tr>