@can('store_request.view')
    <a href="{{route('admin.request.show',$model->id)}}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" >{{ _lang('Request Details') }}</a>
    <a href="{{route('admin.approve_all_request',$model->id)}}" class="btn btn-primary btn-sm has-tooltip" data-original-title="null" target="_blank" >{{ _lang('Approve All') }}</a>
@endcan
@can('store_request.delete')
    <button id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.mainrequest.destroy',$model->id)  }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
    data-placement="bottom"><i class="fa fa-trash"></i></button>
@endcan
@can('store_request.view')
    <a onclick="myFunction('{{route('admin.store_request_print',$model->id)}}')" class="btn btn-info btn-sm text-light has-tooltip" data-original-title="null" ><i class="fa fa-print"></i></a>
@endcan
