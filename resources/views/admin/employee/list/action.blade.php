@can('employee_list.access')
    <a data-placement="bottom" title="View Details for Employee {{$model->id}} ." href="{{ route('admin.employee-list.edit',$model->uuid) }}"  class="btn btn-primary text-light" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-adjust"></i></a>
@endcan