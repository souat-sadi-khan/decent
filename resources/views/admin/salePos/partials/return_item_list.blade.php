<h3 style="text-align: center;">{{_lang('Return Item')}}</h3>
<table class="table table-bordered ">
  <thead class="bg-green text-light">
    <th class="text-center">#</th>
    <th class="text-center">{{_lang('Item')}}</th>
    <th class="text-center">{{_lang('Qty')}}</th>
    @can('view_sale.return_amt')
    <th class="text-center">{{_lang('Unit Price')}}</th>
    @endcan
    <th class="text-center">{{_lang('Total')}}</th>
  </thead>
  <tbody>
    @php
    $total_before_tax = 0;
    @endphp
    @foreach($model->sell_lines as $return)
    @if($return->quantity_returned == 0)
    @continue
    @endif
    <tr>
      <td class="text-center">{{$loop->iteration}}</td>
      <td class="text-center">{{ $return->product->name }}-{{$return->variation?$return->variation->name:''}}</td>
      <td class="text-center">{{$return->quantity_returned}}</td>
      @can('view_sale.return_amt')
      <td class="text-center">{{$return->unit_price }}</td>
      @php
      $line_total = $return->unit_price * $return->quantity_returned;
      $total_before_tax += $line_total ;
      @endphp
      <td class="text-center">{{$line_total }}</td>
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
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $total_before_tax }}</span></td>
          </tr>
          <tr>
            <th>@lang('Discount'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->discount_amount ??  $model->discount_amount }}</span></td>
          </tr>

            <tr>
            <th>@lang('Tax'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->tax ??  $model->tax }}</span></td>
          </tr>
          <tr>
            <th>@lang('Net Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->net_total ??  $model->net_total }}</span></td>
          </tr>
    
          <tr>
            <th>@lang('Return Total'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $model->return_parent->net_total ??  $model->net_total }}</span></td>
          </tr>

            <tr>
            <th>@lang('Print'):</th>
            <td></td>
            <td><button type="button" class="btn btn-danger btn-sm pull-right" onclick="myFunction('{{route('admin.sale.return.printpage',$model->return_parent->return_parent_id)}}')">{{ _lang('Print') }}</button></td>
          </tr>
          
        </table>
      </div>
    </div>