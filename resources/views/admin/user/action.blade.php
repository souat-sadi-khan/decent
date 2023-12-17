<ul class="nav nav-tabs" id="action_menu_{{$model->id}}">
    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
        <div class="dropdown-menu">
            @can('user.update')
                <a data-placement="bottom" title="Edit {{$model->username}} User Information." class="dropdown-item" href="{{ route('admin.user.edit',$model->id) }}"><i class="fa fa-pencil-square-o"></i> {{_lang('edit')}}</a>
            @endcan

            @can('user.delete')
                <a data-placement="bottom" title="Delete Forever {{$model->username}} User Information." class="dropdown-item" href="#" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.user.delete',$model->id) }}"><i class="fa fa-trash"></i>{{_lang('delete')}}</a>
            @endcan
        </div>
    </li>
</ul>