@can('employee_payroll_init.update')
    {{-- <a style="cursor:pointer;" id="content_managment" data-placement="bottom" title="Edit Employee Salary Structure." href="{{ route('admin.payroll-initialize.edit',$model->uuid)}}"  class="text-info" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o fa-2x ml-1"></i></a> --}}
@endcan

@can('employee_payroll_init.print')
    <a target="blank" data-placement="bottom" title="Print the Payroll" href="{{ route('admin.payroll-initialize.print',$model->uuid) }}" class="text-secondary" title="{{ _lang('Print') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-print fa-2x ml-1"></i></a>
@endcan

@can('employee_payroll_init.view')
    <a style="cursor:pointer;" id="content_managment" data-placement="bottom" title="Edit Employee Salary Structure." data-url="{{ route('admin.payroll-initialize.show',$model->uuid) }}" id="content_managment" class="text-success" title="{{ _lang('View') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-eye fa-2x ml-1"></i></a>
@endcan

@can('employee_payroll_init.delete')
    <a style="cursor:pointer;" id="delete_item" data-id ="{{$model->id}}" data-placement="bottom" title="Delete Employee Salary Structure." href="" id="delete_item" data-id ="{{$model->uuid}}" data-url="{{route('admin.payroll-initialize.destroy',$model->uuid) }}" class=" text-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash fa-2x ml-1"></i></a>
@endcan