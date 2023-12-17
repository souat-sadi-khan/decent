@can('holiday.update')
<a data-placement="bottom" title="Edit Holiday." data-url="{{ route('admin.holiday.edit',$model->id) }}" id="content_managment" class="btn btn-info text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan

@can('holiday.delete')
<a data-placement="bottom" title="Delete Holiday." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.holiday.destroy',$model->id) }}" class="btn btn-danger" title="{{ _lang('Delsdfsfsdete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan