@if ($model->status !='requisition')
@can('production_work_order.update')
    <a class="btn btn-info btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-work-order.edit',$model->id)}}" ><i class="fa fa-edit"></i></a>
@endcan
@can('production_work_order.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.production-work-order.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan
@can('production_work_order.view')
    <a class="btn btn-info btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-work-order.show',$model->id)}}" ><i class="fa fa-eye"></i></a>
@endcan
@endif
@if ($model->status =='requisition')
@can('production_work_order.view')
    <a class="btn btn-info btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-work-order.show',$model->id)}}" ><i class="fa fa-eye"></i></a>
@endcan
@endif

@if ( $model->type != 'sample' && $model->payment_status == 0)
    <button id="content_managment" data-url="{{route('admin.production-work-order.pay',$model->id)  }}" class="btn btn-success btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-paypal"></i></button>
@endif
@if ($model->type == 'production')
    <a target="_blank" data-toggle="tooltip" data-placement="bottom" title="Delivery" class="btn btn-warning btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.production-work-order.delivery',$model->id)}}" ><i class="fa fa-star"></i></a>
@endif