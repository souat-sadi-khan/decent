<h3>{{ _lang('Sale Item') }}</h3>
<table class="table table-bordered">
  <thead class="bg-green text-light">
    <tr>
      <th>{{ _lang('Name') }}</th>
      @can('view_sale.qty')
      <th>{{ _lang('Qty') }}</th>
      @endcan
      @can('view_sale.sale_price')
      <th>{{ _lang('Price') }}</th>
      <th>{{ _lang('Total') }}</th>
      @endcan
    </tr>
  </thead>
  <tbody>
    @foreach ($model->sell_lines as $sale)
    <tr>
      <td>{{$sale->variation->name }}-{{$sale->product->name }}</td>
      @can('view_sale.qty')
      <td>{{ $sale->quantity }}</td>
      @endcan
      @can('view_sale.sale_price')
      <td>{{ $sale->unit_price }}</td>
      <td>
        {{ $sale->total }}
      </td>
      @endcan
    </tr>
    @endforeach
  </tbody>
</table>

  <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <table class="table">
          <tr>
            <th>@lang('Sub Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->sub_total }}</span></td>
          </tr>
          <tr>
            <th>@lang('Discount'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{  $model->discount_amount }}</span></td>
          </tr>

            <tr>
            <th>@lang('Tax'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->tax }}</span></td>
          </tr>
          <tr>
            <th>@lang('Net Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->net_total }}</span></td>
          </tr>
    
          <tr>
            <th>@lang('Paid'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{  $model->payment->sum('amount') }}</span></td>
          </tr>

           <tr>
            <th>@lang('Due'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{  $model->net_total-$model->payment->sum('amount') }}</span></td>
          </tr>

          <tr>
            <th>{{ _lang('Print') }}</th>
            <td></td>
            <td><button type="button" class="btn btn-danger btn-sm pull-right" onclick="myFunction('{{route('admin.sale.pos.print',$model->id)}}')">{{ _lang('Print') }}</button></td>
          </tr>
        </table>
      </div>
    </div>