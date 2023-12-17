@if ($model->id != 1 && $model->id != 2 && $model->id != 3)
    @can('employee_attendance_type.update')
        <button class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.attendance-attendance-type.edit',$model->id)}}" ><i class="fa fa-edit"></i></button>
    @endcan
    @can('employee_attendance_type.delete')
        <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.attendance-attendance-type.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-trash"></i></button>
    @endcan
@else
    <p class="text-danger">This is Default Option. <br> You Can't Change it.</p>

@endif

