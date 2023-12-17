<div class="dropdown">
	<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		@can('sale_pos.update')
		<a href="{{route('admin.sale.pos.show',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-eye-slash" aria-hidden="true"></i>{{ _lang('Details') }}</a>
		@endcan
		@can('sale_pos.view')
		<a id="content_managment" data-url="{{route('admin.sale.pos.view',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-cart-plus" aria-hidden="true"></i>{{ _lang('View') }}</a>
		@endcan
		@can('transaction_payment.create')
		<a id="content_managment" data-url="{{route('admin.sale.pos.payment',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-money" aria-hidden="true"></i>{{ _lang('Payment') }}</a>
		@endcan
		@can('sale_pos.create')
        <a href="{{route('admin.sale.return_sale',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-reply-all" aria-hidden="true"></i>{{ _lang('Return') }}</a>
		@endcan
		@can('sale_pos.view')
        <a onclick="myFunction('{{route('admin.sale.pos.print',$model->id)}}')"  class="dropdown-item cursour"><i class="fa fa-print" aria-hidden="true"></i>{{ _lang('Print') }}</a>
		@endcan
		@can('email_marketing.create')
        <a id="content_managment" data-url="{{route('admin.sale.get_notification',$model->id)}}" class="dropdown-item cursour"><i class="fa fa-envelope" aria-hidden="true"></i>{{ _lang('Sale Notification') }}</a>
        @endcan
		@can('sale_pos.delete')
		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.sale.pos.destroy',$model->id)  }}"><i class="fa fa-trash"></i>{{ _lang('Trash') }}</a>
		@endcan
	</div>
</div>