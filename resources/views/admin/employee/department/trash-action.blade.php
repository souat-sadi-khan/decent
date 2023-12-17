@can('employee_department.restore')
    <a style="cursor:pointer;" data-placement="bottom" title="Restore Employee Department." data-url="{{ route('admin.trash.employee-department.restore',$model->id) }}" id="restore_item" class=" text-primary mr-2" title="{{ _lang('Edit') }}" data-popup="tooltip" ><i class="fa fa-rebel"></i></a>
@endcan
@can('employee_department.force_delete')
    <a style="cursor:pointer;"  data-placement="bottom" title="Force Delete Employee Department." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.trash.employee-department.destroy',$model->id) }}" class="text-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan