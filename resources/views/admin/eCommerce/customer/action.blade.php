<a class="btn btn-info btn-sm has-tooltip" data-original-title="null"  href="{{route('admin.e_customer.view',$model->id)}}" ><i class="fa fa-eye-slash"></i></a>

@can('ecommerce_customer.delete')
    <a class="btn btn-danger btn-sm cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.e_customer.delete',$model->id)  }}"><i class="fa fa-trash"></i></a>
@endcan