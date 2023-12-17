<ul>
	@foreach ($models as $key => $model) 
	<li id="{{ $model->id }}" class="{{ ($model->childs->count() > 0 ? 'jstree-closed' : '') }}">
		<span>{{ $model->name }} 
              {{-- Catagory Edit --}}
                @can('production_category.update')
                    <i id="content_managment" class="icon fa fa-pencil-square-o ml-1 edit"
                       data-url="{{route('admin.production-category.edit', $model->id) }}"></i>
                @endcan

{{-- Catagory Delete --}}
                @can('production_category.delete')
                    <i class="icon fa fa-trash-o text-danger ml-1 delete"  id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-category.destroy',$model->id) }}"></i>
                @endcan
		</span>
	</li>
	@endforeach
</ul>