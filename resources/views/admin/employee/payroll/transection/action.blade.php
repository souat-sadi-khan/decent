{{-- @can('employee_payroll_template.update')
    <a style="cursor:pointer;" data-placement="bottom" title="Edit Employee Payroll Transaction." data-url="{{ route('admin.payroll-transection.edit',$model->id) }}" id="content_managment" class="text-info" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o fa-2x ml-1"></i></a>
@endcan --}}
<a style="cursor:pointer;" data-placement="bottom" title="Print Employee Payroll Transaction." data-url="{{ route('admin.transaction_print',$model->id) }}" id="content_managment" class="text-prinmary" title="{{ _lang('Print') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-print fa-2x"></i></a>

@can('employee_payroll_transection.view')
<a style="cursor:pointer;" data-placement="bottom" title="View Employee Payroll Transaction." data-url="{{ route('admin.payroll-transection.show',$model->id) }}" id="content_managment" class="text-success" title="{{ _lang('View') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-eye fa-2x"></i></a>
@endcan


@can('employee_payroll_transection.delete')
<a data-placement="bottom" title="Delete Employee Payroll Transaction." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.payroll-transection.destroy',$model->id) }}" class="text-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash fa-2x"></i></a>
@endcan