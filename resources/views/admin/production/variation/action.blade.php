@can('production_variation.update')
    <button class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.production-variation.edit',$model->id)}}" ><i class="fa fa-edit"></i></button>
@endcan
{{-- @can('production_variation.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-variation.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan --}}


