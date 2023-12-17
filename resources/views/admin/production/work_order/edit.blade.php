@extends('layouts.app', ['title' => _lang('Production Work Order edit'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Work Order for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Production work order edit')}}</h1>
        <p>{{_lang('edit work order for Production.')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{Breadcrumbs::render('work-order-edit') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-work-order.update', $model->id)}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Edit Production work order')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="prefix">{{_lang('Code')}} <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix" value="{{$model->prefix}}" required></div>
                        <div class="col-md-8">
                            <input type="text" name="code" id="code" class="form-control" placeholder="Code Here" required value="{{$model->code}}"></div>
                    </div>
                </div>


                {{-- Select  Brand --}}
                <div class="col-md-4 form-group">
                    <label for="brand_id">{{_lang('Select Brand')}}</label>
                    <select data-placeholder="Select One" name="brand_id" id="brand_id" class="form-control select">
                        <option value="">Select One</option>
                        @foreach ($brand as $item)
                            <option {{$model->brand_id == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Select  work Order Type --}}
                <div class="col-md-4 form-group">
                    <label for="type">{{_lang('Work Order Type')}} <span class="text-danger">*</span>
                    </label>
                    <select data-placeholder="Select One" name="type" id="type" class="form-control select">
                        <option value="">Select One</option>
                        <option {{ $model->type == 'sample' ? 'selected' : '' }} {{ $model->type == 'production' ? 'disabled' : '' }}  value="sample">Sample</option>
                        <option {{ $model->type == 'production' ? 'selected' : '' }} value="production">Production</option>
                    </select>
                </div>

                {{-- Select Work Order Date --}}
                <div class="col-md-4 form-group">
                    <label for="date">{{_lang('Work Order date')}}</label>
                    <input type="text" readonly name="date" id="date" value="{{$model->date}}" class="form-control date" />
                </div>

                {{-- Select Work Order Delivery Date --}}
                <div class="col-md-4 form-group">
                    <label for="delivery_date">{{_lang('Delivery Date')}}</label>
                    <input type="text" readonly name="delivery_date" value="{{$model->delivery_date}}" id="delivery_date" class="form-control date" />
                </div>

                <div class="col-md-4 form-group">
                    <label for="name">{{_lang('Select Product')}} <span class="text-danger">*</span>
                    </label>
                    <select id="select_product" class="form-control select" data-placeholder="Select A Product">
                        <option value="">Select A Product</option>
                        @foreach ($models as $product)
                            <option {{ in_array($product->id, $product_array) ? 'disabled' : '' }} value="{{ $product->id }}">{{ $product->name }} ({{ $product->articel }}) </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
            <input type="hidden" value="0"  id="row" >
        <div class="card-header">
            <h6>{{_lang('Work Order Product For production')}}</h6>
        </div>
         <input type="hidden" value="0"  id="row" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table update_invoice_table table-bordered">
                        <thead>
                            <tr>
                                {{-- <td>{{_lang('Product Name')}}</td>
                                <td>{{_lang('Quantity')}}</td>
                                <td>{{_lang('price')}}</td>
                                <td>{{_lang('Sub Total')}}</td>
                                <td>{{_lang('Net Total')}}</td>
                                <td>{{_lang('Action')}}</td> --}}
                                <td class="text-center"> <i class="fa fa-trash-o text-danger" aria-hidden="true"></i> </td>
                                <td>{{_lang('Product Name')}}</td>
                                <td>{{_lang('Quantity')}}</td>
                                <td>{{_lang('Price')}}</td>
                                <td>{{_lang('Sub Total')}}</td>
                            </tr>
                        </thead>
                        <tbody id="item">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($model->workOrderProduct as $key => $produc_titem)
                            @php
                            // dd($produc_titem);
                                $total += $produc_titem->qty*$produc_titem->price;
                            @endphp
                            {{-- <tr> --}}
                                <tr>
                                    <td class="text-center">
                                        <i style="cursor: pointer;" class="fa fa-trash text-danger remove" aria-hidden="true"></i>
                                    </td>
                                    <td>
                                        {{$produc_titem->product->name}} {{ \App\models\Production\Variation::where('id', $produc_titem->variation_id)->first() ? \App\models\Production\Variation::where('id', $produc_titem->variation_id)->first()->name : '' }}

                                        <input type="hidden" name="product_id[]" class="product_id" value="{{$produc_titem->product_id}}" data-variation="{{$produc_titem->variation_id}}">
                                        <input type="hidden" name="variation_id[]" class="variation_id" value="{{$produc_titem->variation_id}}">
                                        <input type="hidden" class="form-controll code" value="{{$produc_titem->product_id}}">
                                        {{-- <input type="hidden" class="form-control code" id="code_{{$row}}" data-id="{{$row}}" value="{{$product->id}}"> --}}
                                    </td>

                                    <td>
                                        <input type="text" autocomplete="off"  name="quantity[]" class="form-control qty" value="{{ $produc_titem->qty }}">
                                    </td>
                                    <td>
                                        <input type="hidden" name="price[]" class="hidden_price" value="{{$produc_titem->price}}">
                                        <input type="text" autocomplete="off" name="price[]" class="form-control price" value="{{$produc_titem->price}}">
                                    </td>
                                    <td>
                                        <input type="hidden" name="sub_total[]" class="sub_total" value="{{$produc_titem->sub_total}}">
                                        <span  class="sub_total_text">{{number_format(1*$produc_titem->sub_total, 2)}}</span>
                                    </td>

                                </tr>
                                {{-- <td>
                                    {{$produc_titem->product->name}} {{ \App\models\Production\Variation::where('id', $produc_titem->variation_id)->first() ? \App\models\Production\Variation::where('id', $produc_titem->variation_id)->first()->name : '' }}
                                    <input type="hidden" name="product_id[]" class="product_id" value="{{$produc_titem->product_id}}">
                                    <input type="hidden" name="variation_id[]" class="variation_id" value="{{$produc_titem->variation_id}}">
                                    <input type="hidden" class="form-controll code" id="code_{{$key}}" data-id="{{$key}}" value="{{$produc_titem->product_id}}">
                                </td>

                                <td>
                                    <input type="text" name="quantity[]" class="form-control qty" id="qty_{{$key}}" value="{{$produc_titem->qty}}">
                                </td>
                                <td>
                                    <input type="text" name="price[]" class="form-control price" value="{{$produc_titem->price}}">
                                </td>
                                <td>
                                    <input type="hidden" name="sub_total[]" class="sub_total" value="{{$produc_titem->qty*$produc_titem->price}}">
                                    <span id="sub_total_{{$key}}" class="sub_total_text">{{$produc_titem->sub_total}}</span>
                                </td>
                                <td>
                                    <input type="hidden" name="net_total[]" class="net_total" value="{{$produc_titem->qty*$produc_titem->price}}">
                                    <span id="net_total_{{$key}}" class="net_total_text">{{$produc_titem->net_total}}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info remove">X</button>
                                </td> --}}
                            {{-- </tr> --}}
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($model->type == 'production')
                    <div class="col-md-12 production_show">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered border-dark" style="margin-bottom: 0px !important">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <span>{{ _lang('Total') }}</span> <br>
                                                <input type="hidden" name="net_total" value="{{ $model->sub_total }}" id="net_total">
                                                <span id="show_net_total">{{ number_format($model->sub_total, 2)}}</span>
                                            </td>
                                            <td style="width: 40%">
                                                <span>{{ _lang('Discount Type') }}</span> <br>
                                                <select name="discount_type" class="form-control" id="discount_type">  {{ $model->discount_type == 'fixed' ? 'selected' : ''}}
                                                    <option {{ $model->discount_type == 'percentage' ? 'selected' : ''}} value="percentage">Percentage</option>
                                                    <option {{ $model->discount_type == 'fixed' ? 'selected' : ''}} value="fixed">Fixed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Discount') }}</span> <br>
                                                <input type="text" autocomplete="off" name="discount" value="{{ $model->discount_amount }}" class="form-control" id="discount_amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>{{ _lang('Discount Value') }}</span> <br>
                                                <input type="text" name="discount_amount" class="form-control" id="total_discount" value="0" readonly>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Tax') }}</span> <br>
                                                <input type="text" autocomplete="off" name="tax" value="{{ $model->tax }}" class="form-control" id="tax_calculation_amount">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Shipping') }}</span> <br>
                                                <input type="text" autocomplete="off" value="{{ $model->shiping_charge }}" name="shipping_charges" class="form-control" id="shipping_charges">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Total Payable') }}</span> <br>
                                                <input type="hidden" class="form-control" value="{{ $model->total_payable }}" id="total_payable_amount" name="total_payable_amount">
                                                <span class="total_payable_amount"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Paid') }} </label>
                                            <input type="text" readonly autocomplete="off" class="form-control paid" value="{{ $model->paid == null ? 0 : $model->paid }}" name="paid" id="paid">
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="due">{{ _lang('Due') }} </label>
                                            <input type="text" class="form-control due" name="due" id="due" value="{{ $model->due }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Method') }} </label>
                                            <input type="text" readonly class="form-control" value="{{ ucfirst($model->method) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 production_show" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered border-dark" style="margin-bottom: 0px !important">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <span>{{ _lang('Total') }}</span> <br>
                                                <input type="hidden" name="net_total" id="net_total" value="{{ $total }}">
                                                <span id="show_net_total">{{ number_format($total, 2)}}</span>
                                            </td>
                                            <td style="width: 40%">
                                                <span>{{ _lang('Discount Type') }}</span> <br>
                                                <select name="discount_type" class="form-control" id="discount_type">
                                                    <option value="percentage">Percentage</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Discount') }}</span> <br>
                                                <input type="text" autocomplete="off" name="discount" class="form-control" id="discount_amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>{{ _lang('Discount Value') }}</span> <br>
                                                <input type="text" name="discount_amount" class="form-control" id="total_discount" value="0" readonly>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Tax') }}</span> <br>
                                                <input type="text" autocomplete="off" name="tax" class="form-control" id="tax_calculation_amount">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Shipping') }}</span> <br>
                                                <input type="text" autocomplete="off" name="shipping_charges" class="form-control" id="shipping_charges">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Total Payable') }}</span> <br>
                                                <input type="hidden" class="form-control" id="total_payable_amount" value="{{ $total }}" name="total_payable_amount">
                                                <span class="total_payable_amount">{{ number_format($total, 2) }} </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Paid') }} </label>
                                            <input type="text" autocomplete="off" class="form-control paid" name="paid" id="paid">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="due">{{ _lang('Due') }} </label>
                                            <input type="text" class="form-control due" name="due" id="due" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="account_id">{{ _lang('Account') }} </label>
                                            <select name="account_id" class="form-control select" id="account_id">
                                                <option value="">Select Account</option>
                                                @foreach ($accounts as $element)
                                                <option>{{ $element->name }}({{ toWord($element->account_type) }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Method') }} </label>
                                            <select name="method" class="form-control method">
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 reference_no" style="display: none;">
                                        <div class="form-group">
                                            <label for="check_no">{{ _lang('Reference') }} </label>
                                            <input type="text" class="form-control" name="check_no" id="check_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sale_note">{{ _lang('Sale Note') }} </label>
                                        <textarea name="sale_note" class="form-control" id="" placeholder="Sale Note"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stuff_note">{{ _lang('Stuff Note') }} </label>
                                        <textarea name="stuff_note" class="form-control" id="" placeholder="Stuff Note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>


        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Update')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-info" id="submiting"
                style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</form>

<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
{{-- <script src="{{ asset('backend/js/plugins/select.min.js') }}"></script> --}}
{{-- <script src="{{ asset('js/production/work_order.js') }}"></script> --}}
<script>
    $('.select').select2({width:'100%'});

    _formValidation();

    $('#type').change(function() {
        var val = $(this).val();
        if(val == 'sample') {
            $('.production_show').fadeOut();
            $('#paid').removeAttr('required');
        } else {
            $('.production_show').fadeIn();
            $('#paid').attr('required', '1');
        }
    });

    $('#select_product').change(function() {
        var product_id = $(this).val();
        get_purchase_entry_row(product_id);
        // $('#select_product').val('');
    });

    $("#item").on('click', '.remove', function () {
        $(this).closest('tr').remove();
        $("#discount_amount").val("");
        $("#discount").val("");
        $("#paid").val("");
    });

    $("#item").on('keyup change', '.qty, .price', function () {
        var tr = $(this).parent().parent();
        update_sub_total(tr);
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();


        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges);

        var paid = $('#paid').val();
        if(paid == '') {
            paid = 0;
        }

        var due = total_payable - parseInt(paid);
        $('#paid').val(paid);
        $('#due').val(due);
        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    function update_sub_total(tr) {
        var qty = tr.find('.qty').val();
        var price = tr.find('.price').val();
        var total = qty * price;
        tr.find('.sub_total').val(total);
        tr.find('.sub_total_text').text(total.toFixed(2));
        var total_function_amount = total_function();
        $('#net_total').val(total_function_amount);
        $('#show_net_total').text(total_function_amount.toFixed(2));
    }

    function total_function()
    {
        var total = 0;
        $('.update_invoice_table tbody tr').each(function(i, element) {

            var html = $(this).html();
            if(html!='')
            {
                var net_total = $(this).find('.sub_total');
                if(net_total.length > 0){
                    total += parseInt(net_total.val());
                }

            }
        });

        return total;
    }

    function get_purchase_entry_row(product_id) {
        //Get item addition method
        var is_added = false;
        //Search for variation id in each row of pos table
        $('#item')
            .find('tr')
            .each(function () {
                var row_v_id = $(this)
                    .find('.product_id')
                    .val();
                if (
                    row_v_id == product_id
                ) {
                    // is_added = true;
                    // //Increment product quantity
                    // qty_element = $(this).find('.qty');
                    // qty_element.val(parseInt(qty_element.val()) + 1);
                    // update_sub_total($(this));
                    // $('input#search_product')
                    //     .focus()
                    //     .select();
                    toastr.warning('Product available');
                    is_added = true;
                }
            });


        if (!is_added && product_id) {
            var row_count = $('#row').val();
            $.ajax({
                method: 'POST',
                url: '/admin/production-work-order/append',
                dataType: 'json',
                data: {product_id: product_id, row_count: row_count},
                success: function (result) {
                    $('#item').append(result.html);

                    if ($(result.html).find('.qty').length) {
                        $('#row').val(
                            $(result.html).find('.qty').length + parseInt(row_count)
                        ).trigger('change');
                    }
                    var net_total = total_function();
                    $('#refresh_net_total').html(net_total.toFixed(2));
                    $('#net_total').val(net_total);
                    $('#show_net_total').html(net_total.toFixed(2));
                    $('.total_payable_amount').html(net_total.toFixed(2));
                    $('#total_payable_amount').val(net_total.toFixed(2));
                },
            });
        }

        // console.log(net_total);
    }

        // discount_type
        $('#discount_amount').keyup(function() {
        var net_total = $('#net_total').val();
        var discount_type = $('#discount_type').val();
        var discount_amount = $(this).val();
        if(discount_amount == '') {
            discount_amount = 0;
        }
        if(discount_type == 'percentage') {
            var discount_amount_for_show = (net_total * discount_amount) / 100;
            $('#total_discount').val(discount_amount_for_show.toFixed(2));
        } else {
            var discount_amount_for_show = parseFloat(discount_amount);
            $('#total_discount').val(discount_amount_for_show.toFixed(2));

        }

        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges);

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));

    });

    // discount_type
    $('#discount_type').change(function() {
        var net_total = $('#net_total').val();
        var discount_type = $('#discount_type').val();
        var discount_amount = $('#discount_amount').val();
        if(discount_amount == '') {
            discount_amount = 0;
        }

        if(discount_type == 'percentage') {
            var discount_amount_for_show = (net_total * discount_amount) / 100;
            $('#total_discount').val(discount_amount_for_show.toFixed(2));
        } else {

            var discount_amount_for_show = parseFloat(discount_amount);
            $('#total_discount').val(discount_amount_for_show.toFixed(2));

        }

        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges);

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    // tax_calculation_amount
    $('#tax_calculation_amount').keyup(function() {
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges);

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    // shipping_charges
    $('#shipping_charges').keyup(function() {
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges);

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    $('#paid').keyup(function() {
        var payable = $('#total_payable_amount').val();
        console.log(payable);
        var paid = $(this).val();
        if(paid == '') {
            paid = 0;
        }
        var due = parseInt(payable) - parseInt(paid);
        $('#due').val(due);
    });
// $(document).ready(function(){
//  $(document).on('change','#product_id',function(){
//         var product_id = $(this).val();
//         var quantity =1;
//         var price = 1;
//      $.ajax({
//          url:"{{route('admin.production-work-order.item')}}",
//          method:'get',
//          dataType:'json',
//          data:{product_id:product_id},
//          success:function(data){
//                 item(data,product_id,quantity,price);
//          }
//      });
//  });

// function item(item, product,quantity,price) {
//     var tr = $("#item").parent().parent();
//     var a = tr.find('.code');
//     if (a.length == 0) {
//         var row = parseInt($("#row").val());
//         $.ajax({
//             type: 'GET',
//             url: "/admin/production-work-order/append",
//             data: {
//                 product: product,
//                 row: row,
//                 quantity: quantity,
//                 price: price,
//             },
//             dateType: 'html',
//             success: function(data) {
//                 $("#item").append(data);
//                 $('#row').val(row + 1);
//             }

//         });
//     } else {
//         var found = true;
//         $(".code").each(function() {
//             if ($(this).val() == item.id) {
//                 var id = $(this).data('id');
//                 var qty = parseFloat($('#qty_' + id).val());
//                 parseFloat($('#qty_' + id).val(qty + quantity));
//                 var nwqty = parseFloat($('#qty_' + id).val());
//                 var amt = nwqty * parseFloat(price);
//                 $("#sub_total_" + id).html(amt);
//                 $("#net_total_" + id).html(amt);
//                 found = false;
//                 return false;

//             }
//         })
//         if (found) {
//             var row = parseInt($("#row").val());
//             $.ajax({
//                 type: 'GET',
//                 url: "/admin/production-work-order/append",
//                 data: {
//                     product: product,
//                     row: row,
//                     quantity: quantity,
//                     price: price,
//                 },
//                 dateType: 'html',
//                 success: function(data) {
//                     $("#item").append(data);
//                     $('#row').val(row + 1);
//                 }

//             });
//         }
//     }
// }

//     $("#item").on('click', '.remove', function() {
//         $(this).closest('tr').remove();
//         $("#discount_amount").val("");
//         $("#discount").val("");
//         $("#paid").val("");
//     });


//     $("#item").on('keyup change', '.qty, .price', function() {
//     var tr = $(this).parent().parent();
//     var qty =tr.find('.qty').val();
//     var price= tr.find('.price').val();
//     var total =qty*price;
//     tr.find('.sub_total').val(total);
//     tr.find('.net_total').val(total);
//     tr.find('.sub_total_text').text(total);
//     tr.find('.net_total_text').text(total);
//     });

// });
</script>
@endpush

