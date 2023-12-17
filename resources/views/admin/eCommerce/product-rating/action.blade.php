@can('ecommerce_product_rating.update')
    <a class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.eCommerce.product-rating.status',$model->id)}}" ><i class="fa fa-refresh"></i></a>
@endcan 

@can('ecommerce_product_rating.delete') 
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.product-rating.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan