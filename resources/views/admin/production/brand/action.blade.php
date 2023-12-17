<div class="dropdown">
	<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		@can('production_brands.update')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.production-brands.edit',$model->id)}}"><i class="fa fa-edit"></i>{{ _lang('Edit') }}</a>
		@endcan
		@can('email_marketing.create')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.brand.mail',$model->id)}}"><i class="fa fa-envelope" aria-hidden="true"></i>{{ _lang('Send Mail') }}</a>
		@endcan
		@can('sms_marketing.create')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.brand.sms',$model->id)}}"><i class="fa fa-commenting" aria-hidden="true"></i>{{ _lang('Send Sms') }}</a>
		@endcan
		@if ($model->id != 1)
			@can('production_brands.delete')
				<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-brands.destroy',$model->id) }}"><i class="fa fa-trash"></i>{{ _lang('Trash') }}</a>
			@endcan
		@endif
	</div>
</div>


