<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.eCommerce.blog-post.edit',$model->id)}}"><i class="fa fa-edit"></i>{{ _lang('Edit') }}</a>
		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.blog-post.destroy',$model->id) }}"><i class="fa fa-trash"></i>{{ _lang('Trash') }}</a>
	</div>
</div>