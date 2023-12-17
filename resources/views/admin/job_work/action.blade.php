<div class="dropdown">
	<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		@can('job_work.update')
		<a href="{{route('admin.job_work.edit',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-eye-slash" aria-hidden="true"></i>{{ _lang('Accept Details') }}
		</a>
		@endcan
        @can('job_work.update')
		<a id="content_managment" data-url="{{route('admin.job_work.payment',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-money" aria-hidden="true"></i>{{ _lang('Payment') }}
		</a>
		@endcan
		@can('job_work.delete')

		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.job_work.destroy',$model->id)  }}"><i class="fa fa-trash"></i>{{ _lang('Trash') }}
		</a>
		@endcan

	</div>
</div>