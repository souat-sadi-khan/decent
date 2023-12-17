<button class="btn btn-success btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.eCommerce.special-offer.show',$model->id)}}" ><i class="fa fa-eye"></i></button>

@can('ecommerce_special_offer.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.special-offer.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan