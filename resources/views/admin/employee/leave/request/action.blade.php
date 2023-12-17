@can('employee_leave_request.view')
<a data-placement="bottom" title="Edit Employee Leave Request." href="{{ route('admin.employee-leave-request.show',$model->uuid) }}"  class="btn btn-success text-light" title="{{ _lang('View') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-eye"></i></a>
@endcan

@if ($model->status == "pending")
@can('employee_leave_request.update')
<a data-placement="bottom" title="Edit Employee Leave Request." data-url="{{ route('admin.employee-leave-request.edit',$model->uuid) }}" id="content_managment" class="btn btn-info text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan
@can('employee_leave_request.delete')
<a data-placement="bottom" title="Delete Employee Leave Request." href="" id="delete_item" data-id ="{{$model->uuid}}" data-url="{{route('admin.employee-leave-request.destroy',$model->uuid) }}" class="btn btn-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan
@endif