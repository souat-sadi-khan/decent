<div class="dropdown">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        {{ _lang('Action') }}
    </button>
    <div class="dropdown-menu">
        @can('purchase.update')
        <a class=" dropdown-item cursourp" data-original-title="null"
            href="{{route('admin.production-purchase.edit',$model->id)}}"><i class="fa fa-edit"></i> {{_lang('Edit')}}</a>
        @endcan
        @can('purchase.view')
        <a class=" dropdown-item cursour" data-original-title="null"
            href="{{route('admin.production-purchase.details',$model->id)}}"><i class="fa fa-asterisk"></i> {{_lang('Details')}}</a>
        @endcan
        @can('purchase.view')
        <a class=" dropdown-item cursour" data-original-title="null"
            href="{{route('admin.purchase.received',$model->id)}}"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{_lang('Received')}}</a>
        @endcan
        @can('purchase.delete')
        <button id="delete_item" data-id="{{$model->id}}"
            data-url="{{route('admin.production-purchase.destroy',$model->id)  }}"
            class=" dropdown-item cursour" data-original-title="null" data-placement="bottom"><i
                class="fa fa-trash"></i> {{_lang('Delete')}}</button>
        @endcan

        @if ($model->due > 0)
        @can('transaction_payment.create')
        <button class=" dropdown-item cursour "
            id="content_managment" data-url="{{route('admin.production-purchase.payment',$model->id)}}"><i
                class="fa fa-credit-card"></i> {{_lang('Add Payment')}}</button>
        @endcan
        @endif
    </div>
</div>
