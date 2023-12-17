@can('employee_leave_type.update')
    <button data-toggle="tooltip" data-placement="bottom" title="Edit {{ $model->name }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.employee-leave-type.edit',$model->id)}}" ><i class="fa fa-edit"></i></button>
@endcan
@can('employee_leave_type.create')
    <button data-toggle="tooltip" data-placement="bottom" title="Delete {{ $model->name }}" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.employee-leave-type.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan