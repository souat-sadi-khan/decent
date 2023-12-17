{{-- @if ($model->transaction_status != 'transaction')
  @can('production_wop_materials.update')
    <a class="btn btn-warning btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-wop-materials.edit',$model->id)}}" ><i class="fa fa-edit"></i></a>
@endcan  
@endif --}}

@can('production_wop_materials.view')
    <a class="btn btn-info btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-wop-materials.show',$model->id)}}" ><i class="fa fa-eye"></i></a>
@endcan

{{-- @if ($model->transaction_status != 'transaction')
@can('production_wop_materials.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-wop-materials.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan
@endif --}}


