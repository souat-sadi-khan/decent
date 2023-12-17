@can('employee_document-type.update')
    <a style="cursor:pointer;" data-placement="bottom" title="Restore Employee Document Type for Users." data-url="{{ route('admin.trash.employee-document-type.restore',$model->id) }}" id="restore_item" class=" text-primary mr-2" title="{{ _lang('Edit') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-rebel"></i></a>
@endcan
@can('employee_document-type.delete')
    <a style="cursor:pointer;"  data-placement="bottom" title="Force Delete Employee Document Type for Users." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.trash.employee-document-type.destroy',$model->id) }}" class="text-danger" title="{{ _lang('Delete') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>
@endcan