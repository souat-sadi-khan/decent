<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		@can('accounting.update')
		<a id="content_managment" data-url="{{route('admin.accounting.account.edit',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-edit"></i>{{ _lang('Edit') }}</a>
		@endcan
		@can('accounting.view')
		<a href="{{route('admin.accounting.account.show',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-eye-slash" aria-hidden="true"></i>{{ _lang('Details') }}</a>
		@endcan
		@can('accounting.create')
		<a id="content_managment" data-url="{{route('admin.accounting.account.getDeposit',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-ravelry" aria-hidden="true"></i>{{ _lang('Deposit') }}</a>
		<a id="content_managment" data-url="{{route('admin.accounting.account.getFundTransfer',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-train" aria-hidden="true"></i>{{ _lang('Transfer') }}</a>
		@endcan
		@can('accounting.delete')

		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.accounting.account_closed',$model->id)  }}"><i class="fa fa-trash"></i>{{ _lang('Close') }}</a>
		@endcan
	</div>
</div>