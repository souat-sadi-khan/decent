@can('email_marketing.view')
    <button class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{route('admin.emailmarketing.template.show',$model->id)}}" > <i class="fa fa-eye-slash" aria-hidden="true"></i></button>
@endcan
@can('email_marketing.update')
    <a href="{{route('admin.emailmarketing.template.edit',$model->id)}}" class="btn btn-info btn-sm has-tooltip" data-original-title="null"  ><i class="fa fa-edit"></i></a>
@endcan
@can('email_marketing.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.emailmarketing.template.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan

