<div class="toggle lg">
	<label id="status_{{$model->id}}"  data-popup="tooltip-custom" data-placement="bottom">
		<input type="checkbox" id="change_hidden" data-id="{{ $model->id }}" data-status="{{ $model->hidden }}" data-url="{{ route('super_admin.hidden',['value'=> ($model->hidden == 1 ? 0 : 1),'id'=>$model->id])  }}" {{ $model->hidden == 1 ? 'checked' : '' }} data-table="{{ $table }}" data-fouc ><span class="button-indecator"></span>
	</label>
</div>
