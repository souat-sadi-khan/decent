@extends('layouts.invoice')
@section('content')
<div class="container-fluid px-4 pt-4">
  <div class="row px-5">
    <div class="col-md-4 text-justify">
      <p class="h3 font-weight-bold text-uppercase text-color"> Bill To</p>
      <p class="text-justify"><span class="font-weight-bold d-inline-block text-color h5 "> Name : {{ $model->client->name }} </span>
    </p>
    <p> <span class="font-weight-bold text-color h5 text-justify"> Address : {{ $model->client->city }} </span>
  </p>
  <p class="text-justify"> <span class="font-weight-bold text-color h5"> E-mail  : {{ $model->client->email }} </span>
</p>
<p><span class="font-weight-bold text-color h5"> Contact : {{ $model->client->mobile }} </span>  </p>
</div>
<div class="col-md-4 ml-auto">
<p class="">
  <span class="font-weight-bold text-uppercase h5"> bill No : {{ $model->reference_no }} </span>
  
</p>
</div>
</div>
<p class="h2 text-uppercase mt-5 text-center"> bill for : {{ _lang('Sales Return for') }} {{ $model->reference_no }} </p>
<div class="row mt-5 px-4">
<table class="table">
<thead>
  <tr class="bg-black">
    <th scope="col" width="5%">{{ _lang('Sl') }}</th>
    <th scope="col" width="10%">{{ _lang('Article') }}</th>
    <th scope="col" width="30%">{{ _lang('Name') }}</th>
    <th scope="col" width="10%">{{ _lang('Variation') }}</th>
    <th scope="col" width="10%">{{ _lang('Unit Price')}}</th>
    <th scope="col" width="15%">{{ _lang('Return Qty')}}</th>
    <th scope="col" width="20%">{{ _lang('Return SubTotal')}}</th>
  </tr>
</thead>
<tbody>
  @php
  $total_before_tax = 0;
  @endphp
  @foreach($model->sell_lines as $sale_line)
  @if($sale_line->quantity_returned == 0)
  @continue
  @endif
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $sale_line->product->articel }}</td>
    <td>{{ $sale_line->product->name }}</td>
    <td>{{ $sale_line->variation->name }}</td>
    <td><span class="display_currency" data-currency_symbol="true">{{ $sale_line->unit_price }}</span></td>
    <td>{{$sale_line->quantity_returned}}</td>
    <td>
      @php
      $line_total = $sale_line->unit_price * $sale_line->quantity_returned;
      $total_before_tax += $line_total ;
      @endphp
      <span class="display_currency" data-currency_symbol="true">{{$line_total}}</span>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
</div>
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
</table>
</div>
</div>
<p class="h2 text-capitalize mt-4 text-center"> In Words : {{ convert_number_to_words($model->return_parent->net_total ??  $model->net_total) }}</p>
<br><br>
<div class="row mt-5 mb-3 text-center">
<div class="col-md-3">
<p class="border-top border-dark h4"> Received By </p>
</div>
<div class="col-md-3">
<p class="border-top border-dark h4 text-color"> Prepared By </p>
</div>
<div class="col-md-3">
<p class="border-top border-dark h4 text-color"> Checked By </p>
</div>
<div class="col-md-3">
<p class="border-top border-dark h4 text-color"> Authorized By </p>
</div>
</div>
</div>
@endsection