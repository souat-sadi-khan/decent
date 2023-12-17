<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.eCommerce.blog-post.comment.show',$model->id)}}"><i class="fa fa-edit"></i>{{ _lang('Show') }}</a>
		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.blog-post.comment.destroy',$model->id) }}"><i class="fa fa-trash"></i>{{ _lang('Delete') }}</a>
	</div>
</div>


