@can('production_category.update')
    <a style="cursor:pointer;" data-placement="bottom" title="Restore Production Category for Users." data-url="{{ route('admin.trash.production-category.restore',$model->id) }}" id="restore_item" class=" text-primary mr-2" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-rebel"></i></a>
@endcan
@can('production_category.create')
    <a style="cursor:pointer;"  data-placement="bottom" title="Force Delete Production Category for Users." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.trash.production-category.destroy',$model->id) }}" class="text-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan