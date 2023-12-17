@can('ecommerce_page_banner.update')
    <button id="content_managment" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.page-banner.edit',$model->id)  }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-pencil"></i></button>
@endcan 

@can('ecommerce_page_banner.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.eCommerce.page-banner.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan