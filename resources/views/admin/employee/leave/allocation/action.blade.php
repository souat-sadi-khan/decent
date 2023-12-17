@can('employee_leave_allocation.update')
<a data-placement="bottom" title="Edit Employee Leave Allocation." data-url="{{ route('admin.employee-leave-allocation.edit',$model->uuid) }}" id="content_managment" class="btn btn-info text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan
@can('employee_leave_allocation.delete')
<a data-placement="bottom" title="Delete Employee Leave Allocation." href="" id="delete_item" data-id ="{{$model->uuid}}" data-url="{{route('admin.employee-leave-allocation.destroy',$model->uuid) }}" class="btn btn-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan