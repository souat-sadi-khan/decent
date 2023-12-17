@extends('layouts.app', ['title' => _lang('Sale Return'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title=""><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Sale Return')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="tile">
    <div class="tile-body">
        <div class="card">
            <div class="card-body">
                <h3>{{ _lang('Parent Sale') }}</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ _lang('Reference No') }} : {{ $sale->reference_no }}</th>
                            <th>{{ _lang('Customer') }} : {{ $sale->client->name }}</th>
                        </tr>
                        <tr>
                            <th>{{ _lang('Date') }} : {{ $sale->date }}</th>
                            <th>{{ _lang('Total Sale') }} : {{ $sale->net_total }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <form action="{{route('admin.sale.return.store')}}" method="post" enctype="multipart/form-data" id="content_form">
           <input type="hidden" name="transaction_id" value="{{ $sale->id }}">
            <div class="card">
                <div class="card-body">
                            <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="reference_no">Reference No</label>
                    <input type="text" name="reference_no" id="reference_no" class="form-control" value="{{ !empty($sale->return_parent->reference_no) ? $sale->return_parent->reference_no : null }}" readonly>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="sale_type">Sale Type</label>
                    <input type="text" name="sale_type" id="sale_type" class="form-control" value="{{ $sale->sale_type }}" readonly>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-sm-12">
                <div class="table-responsive">
                <table class="table" id="purchase_return_table" style="background: #eee">
                    <thead>
                        <tr class="bg-green text-light">
                            <th>#</th>
                            <th>@lang('Product Name')</th>
                            <th>@lang('Unit Price')</th>
                            <th>@lang('Sale Qty')</th>
                            <th>@lang('Quantity Remaining')</th>
                            <th>@lang('Return Quantity')</th>
                            <th>@lang('Return Subtotal')</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray">
                        @foreach($sale->sell_lines as $sale_line)
                        @php
                        $qty_available = $sale_line->quantity
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $sale_line->product->name }}
                                - {{ $sale_line->variation->name}}
                            </td>
                            <td><span class="display_currency" data-currency_symbol="true">{{ $sale_line->unit_price }}</span></td>
                            <td><span class="display_currency" data-is_quantity="true" data-currency_symbol="false">{{ $sale_line->quantity }}</span></td>
                            <td><span class="display_currency" data-currency_symbol="false" data-is_quantity="true">{{ $qty_available-$sale_line->quantity_returned }}</span> 
                                <input type="hidden" class="qty_available" value="{{ $qty_available }}">
                            </td>
                            <td>
                                <input type="text" name="returns[{{$sale_line->id}}]" value="{{$sale_line->quantity_returned}}"
                                class="form-control input-sm input_number return_qty input_quantity">
                                <span class="text-danger return_error"></span>
                                <input type="hidden" class="unit_price" value="{{$sale_line->unit_price}}">
                            </td>
                            <td>
                                <div class="return_subtotal">{{ $sale_line->quantity_returned*$sale_line->unit_price }}</div>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
        <br>

            <div class="row">
                @php
                    $discount_type = !empty($sale->return_parent->discount_type) ? $sale->return_parent->discount_type : $sale->discount_type;
                    $discount_amount = !empty($sale->return_parent->discount_amount) ? $sale->return_parent->discount_amount : $sale->discount_amount;
                    $discount = !empty($sale->return_parent->discount) ? $sale->return_parent->discount : $sale->discount;
                @endphp
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="discount_type">@lang('Discount Type')</label>
                          <select name="discount_type" class="form-control" id="discount_type">
                            <option value="">None</option>
                            <option {{ $discount_type=='percentage'?'selected':'' }} value="percentage">Percentage</option>
                            <option {{ $discount_type=='fixed'?'selected':'' }} value="fixed">Fixed</option>
                         </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="discount">@lang('Discount Amount')</label>
                        <input type="text" name="discount" class="form-control" id="discount" value="{{ $discount }}">
                    </div>
                </div>
                <div class="col-sm-4">
                     <div class="form-group">
                        {{ Form::label('method', _lang('Payment Account')) }}
                        {!! Form::select('account_id', $accounts,$account_id, ['class' => 'form-control account_id select', 'required']); !!}
                     </div>
                </div>
                 <input type="hidden" name="discount_amount" id="discount_amount" class="return_discount" value="{{ $discount_amount }}">
            </div>
            @php
                $tax_percent = 0;
                if(!empty($sale->tax)){
                    $tax_percent = $sale->tax;
                }
            @endphp
              <input type="hidden" name="tax_amount" id="tax_amount">
              <input type="hidden" name="tax_percent" id="tax_percent" value="{{ $tax_percent }}">
              <input type="hidden" name="total_return" id="total_return" >
                <div class="row">
                <div class="col-sm-12 text-right">
                    <strong>@lang('Total Return Discount'):</strong> 
                    &nbsp;(-) <span id="total_return_discount"></span>
                </div>
                <div class="col-sm-12 text-right">
                    <strong>@lang('Total Return Tax') -{{$sale->tax}}: </strong> 
                    &nbsp;(+) <span id="total_return_tax"></span>
                </div>
                <div class="col-sm-12 text-right">
                    <strong>@lang('Return Total'): </strong>&nbsp;
                    <span id="net_return">0</span> 
                </div>
            </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right" id="submit">@lang('Return')</button>
                <button type="button" class="btn pull-right btn-info" id="submiting" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
            </div>
        </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
_formValidation();

    update_sale_return_total();
  $(document).on('change', 'input.return_qty, #discount_amount, #discount_type', function(){
      // var tr =$('input.return_qty').parent().parent();
      // var qty =$('input.return_qty');
      // if (isNaN(qty.val())) {
              //   toastr.error('Please Enter Valid Quantity');
              //   qty.val("");

              // }
              // else{
              //   if ((qty.val() -0) > (tr.find('input.qty_available').val()-0)) {
              //     toastr.error('Sorry! this much not quantity is not available');
              //     $('#return_error').text('quantity is not available')
              //     qty.val("");
              //   }
              // }
        update_sale_return_total()
    });

    function update_sale_return_total(){
        var net_return = 0;
        $('table#purchase_return_table tbody tr').each( function(){
            var qty =$(this).find('input.return_qty');
             if (isNaN(qty.val())) {
                toastr.error('Please Enter Valid Quantity');
                qty.val("");

              }
              else{
                if ((qty.val() -0) > ($(this).find('input.qty_available').val()-0)) {
                  toastr.error('Sorry! this much not quantity is not available');
                  $(this).find('.return_error').text('quantity is not available')
                  qty.val($(this).find('input.qty_available').val());
                }
              }
            var quantity = $(this).find('input.return_qty').val();
            var unit_price = $(this).find('input.unit_price').val();
            var subtotal = quantity * unit_price;
            $(this).find('.return_subtotal').text(subtotal);
            net_return += subtotal;
        });
        var discount = 0;
        if($('#discount_type').val() == 'fixed'){
            discount =$("#discount").val();
        } else if($('#discount_type').val() == 'percentage'){
            var discount_percent = $("#discount").val();
            discount = __calculate_amount('percentage', discount_percent, net_return);
        }
        discounted_net_return = net_return - discount;

        var tax_percent = $('input#tax_percent').val();
        var total_tax = __calculate_amount('percentage', tax_percent, discounted_net_return);
        var net_return_inc_tax = total_tax + discounted_net_return;

        $('input#tax_amount').val(total_tax);
        $('span#total_return_discount').text(discount);
        $('.return_discount').val(discount);
        $('span#total_return_tax').text(total_tax);
        $('span#net_return').text(net_return_inc_tax);
        $('#total_return').val(net_return_inc_tax);
    }



function __calculate_amount(calculation_type, calculation_amount, amount) {
    var calculation_amount = parseFloat(calculation_amount);
    calculation_amount = isNaN(calculation_amount) ? 0 : calculation_amount;

    var amount = parseFloat(amount);
    amount = isNaN(amount) ? 0 : amount;

    switch (calculation_type) {
        case 'fixed':
            return parseFloat(calculation_amount);
        case 'percentage':
            return parseFloat((calculation_amount / 100) * amount);
        default:
            return 0;
    }
}
</script>
@endpush