@if ($model->sub_type=='ecommerce')
 <a class="btn btn-info btn-sm has-tooltip" target="_blank" data-original-title="null"  href="{{route('admin.e_customer.view',$model->id)}}" ><i class="fa fa-eye-slash"></i></a>
 @else
 <div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	{{ _lang('Action') }}
	</button>
	<div class="dropdown-menu">
		@can('client.update')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.client.edit',$model->id)}}"><i class="fa fa-edit"></i>{{ _lang('Edit') }}</a>
		@endcan
		@can('transaction_payment.create')
		@if(($model->total_invoice + $model->opening_balance - $model->invoice_received - $model->opening_balance_paid)>0)
         <a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.client_pay_due',[$model->id,'type'=>'Sale'])}}"><i class="fa fa-money"></i>{{ _lang('Pay Due') }}</a>
		@endif
		@endcan
		@can('transaction_payment.create')
		@if(($model->total_sale_return - $model->sale_return_paid) > 0)
          <a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.client_pay_due',[$model->id,'type'=>'sale_return'])}}"><i class="fa fa-money"></i>{{ _lang('Pay Return Due') }}</a>
		@endif
		@endcan
		@can('client.view')
		<a class="dropdown-item cursour" href="{{route('admin.client.show',$model->id)}}"><i class="fa fa-eye-slash"></i>{{ _lang('View') }}</a>
		@endcan
		@can('email_marketing.create')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.client.mail',$model->id)}}"><i class="fa fa-envelope" aria-hidden="true"></i>{{ _lang('Send Mail') }}</a>
		@endcan
		@can('sms_marketing.create')
		<a class="dropdown-item cursour" id="content_managment" data-url="{{route('admin.client.sms',$model->id)}}"><i class="fa fa-commenting" aria-hidden="true"></i>{{ _lang('Send Sms') }}</a>
		@endcan
		@can('client.delete')
		<a class="dropdown-item cursour" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.client.destroy',$model->id)  }}"><i class="fa fa-trash"></i>{{ _lang('Trash') }}</a>
		@endcan
	</div>
</div>
@endif