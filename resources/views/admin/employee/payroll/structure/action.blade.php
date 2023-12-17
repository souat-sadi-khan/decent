{{-- @can('employee_payroll_salary_structure.update')
    <a id="content_managment" data-placement="bottom" title="Edit Employee Salary Structure." href="{{ route('admin.payroll-s-structure.edit',$model->id) }}"  class="btn btn-info text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan --}}

@can('employee_payroll_salary_structure.view')
    <a id="content_managment" data-placement="bottom" title="Edit Employee Salary Structure." data-url="{{ route('admin.payroll-s-structure.show',$model->uuid) }}" id="content_managment" class="btn btn-success text-light" title="{{ _lang('View') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-eye"></i></a>
@endcan

@can('employee_payroll_salary_structure.delete')
    <a id="delete_item" data-id ="{{$model->id}}" data-placement="bottom" title="Delete Employee Salary Structure." href="" id="delete_item" data-id ="{{$model->uuid}}" data-url="{{route('admin.payroll-s-structure.destroy',$model->uuid) }}" class="btn btn-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan