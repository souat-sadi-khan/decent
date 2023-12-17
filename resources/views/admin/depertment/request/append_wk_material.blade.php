@foreach ($models->wop_material as $item)
@php
$exit_prev =App\models\depertment\StoreRequest::where('work_order_id',$item->wo_id)->where('raw_material_id',$item->raw_material_id)->sum('qty');
@endphp
<tr>
	<td>
		<input type="hidden" name="raw_material_id[]" value="{{ $item->raw_material_id }}" class="pid">
		{{ $item->work_order_product->product->name }}({{ $item->raw_material->name }})
	</td>
	
	<td>
		<div class="input-group mb-3">
			<input type="text" class="form-control" value="{{ $exit_prev }}" readonly>
			<div class="input-group-append">
				<span class="input-group-text">{{ $item->raw_material->unit->unit }}</span>
			</div>
		</div>
	</td>
	<td>
		<div class="input-group mb-3">
			<input type="text" class="form-control input_number qty qty_{{$item->id}}" id="{{$item->id}}" name="qty[]" value="{{ $item->qty }}" required data-parsley-errors-container=".qty_error">
			<div class="input-group-append">
				<span class="input-group-text">{{ $item->raw_material->unit->unit }}</span>
			</div>
			<span class="qty_error"></span>
		</div>
		
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr>
@endforeach