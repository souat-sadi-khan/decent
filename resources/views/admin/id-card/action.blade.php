@can('employee_id_card.update')
    <a data-placement="bottom" title="Edit Employee Id Card." data-url="{{ route('admin.id-card-template.edit',$model->id) }}" id="content_managment" class="btn btn-info text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan
@can('employee_id_card.delete')
    <a data-placement="bottom" title="Delete Employee Id Card." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.id-card-template.destroy',$model->id) }}" class="btn btn-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan