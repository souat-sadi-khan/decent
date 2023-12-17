<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        {{ _lang('Action') }}
    </button>
    <div class="dropdown-menu">
@can('production_product.update')
    <a class="dropdown-item cursourp" data-original-title="null"  href="{{route('admin.production-product.edit',$model->id)}}" ><i class="fa fa-edit"></i>{{_lang('Edit')}}</a>
@endcan
@can('production_product.view')
    <a class="dropdown-item cursourp" data-original-title="null"  href="{{route('admin.production-product.show',$model->id)}}" ><i class="fa fa-eye"></i>{{_lang('View')}}</a>
@endcan
@can('production_product.view')
    <a class="dropdown-item cursourp" data-original-title="null"  href="{{route('admin.production-product.variation-show',$model->id)}}" ><i class="fa fa-eye"></i>{{_lang('Variation View')}}</a>
@endcan
@can('production_product.view')
    <a class="dropdown-item cursourp" data-original-title="null"  href="{{route('admin.production-product.variation-add-more',$model->id)}}" ><i class="fa fa-plus"></i>{{_lang('Variation Add')}}</a>
@endcan
@can('production_product.view')
    <a class="dropdown-item cursourp btn " data-original-title="null"   href="{{route('admin.production-product.details-add',$model->id)}}" ><i class="fa fa-plus"></i>{{_lang('Add Details For Ecommerce')}}</a>
@endcan
@can('production_product.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-product.destroy',$model->id)  }}" class="dropdown-item cursourp" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i>{{_lang('Delete')}}</button>
@endcan

    </div>
</div>

