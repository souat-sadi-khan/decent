@php
    
    $find_shiping_address = App\models\eCommerce\ClientShippingAddress::where('transaction_id', $model->id)->first();
    if($find_shiping_address) {
        $x = 1;
    } else {
        $x = 0;
    }

    function get_product_code($id) {
        $query = App\models\Production\Product::where('id', $id)->first();
        if($query) {

            if($query->prefix != '' ) {
                $prefix = $query->prefix;
            } else {
                $prefix = '';
            }

            if($query->code != '' ) {
                $code = $query->code;
            } else {
                $code = '';
            }

            $name = $prefix . '-' . $code;

        } else {
            $name = 'No Product Found';
        }

        return $name;

    }

    function get_product_name($id) {
        $query = App\models\Production\Product::where('id', $id)->first();
        if($query) {

            $name = $query->name;

        } else {
            $name = 'No Product Found';
        }

        return $name;
    }

    function get_product_image($id) {
        $query = App\models\Production\Product::where('id', $id)->first();
        if($query) {

            $name = '<img width="100px;" alt="Product Image" src="/storage/product/'.$query->photo.'">';

        } else {
            $name = 'No Product Found';
        }

        return $name;
    }

    function get_product_color($id) {
        $query = App\models\Production\Variation::where('id', $id)->first();
        if($query) {
            $variation_value_id = $query->variation_value_id_2;
            $find = App\models\Production\VariationTemplateDetails::where('id', $variation_value_id)->first();

            if($find) {
                $name = $find->name;
            } else {
                $name = 'Color Not Found';
            }
        } else {
            $name = 'No Color Found';
        }

        return $name;
    }

    function get_product_size($id) {
        $query = App\models\Production\Variation::where('id', $id)->first();
        if($query) {
            $variation_value_id = $query->variation_value_id;
            $find = App\models\Production\VariationTemplateDetails::where('id', $variation_value_id)->first();

            if($find) {
                $name = $find->name;
            } else {
                $name = 'Color Not Found';
            }
        } else {
            $name = 'No Color Found';
        }

        return $name;
    }
@endphp
@extends('layouts.app', ['title' => _lang('Ecommerce Order List'), 'modal' => 'xl'])
@push('admin.css')
@endpush
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="E-Commerce Order List."><i class="fa fa-shopping-cart mr-4"></i> {{_lang('Update eCommerce Order')}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('ecommerce-ordeer-list') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <form action="{{ route('admin.eCommerce.update_report', $model->id) }}" id="content_form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="tile-body" id="data">
                        <div class="row">
                            {{-- Order Detailse --}}
                            <div class="col-md-12 table-responsive">
                                <h6 class="text-center">{{_lang('Order Details')}} - {{ $model->reference_no }} </h6>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th class="text-center" width="20%">{{_lang('Status')}}</th>
                                        <td width="80%" class="text-center"> {{ toWord($model->ecommerce_status) }} </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="20%">{{_lang('eCommerce Orderer Name')}}</th>
                                        <td width="80%"><input readonly type="text" name="client_name" class="text-center form-control" value="{{get_client_name($model->client_id)}}"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="50%">{{_lang('Phone')}}</th>
                                        <td><input type="text" readonly name="client_phone" class="text-center form-control" value="{{get_client_phone($model->client_id)}}"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="50%">{{_lang('Address')}}</th>
                                        <td>
                                            <div class="address_show">
                                                <textarea readonly name="client_address" class="form-control text-center" cols="30" rows="2">{{get_client_address($model->client_id)}}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="50%">{{_lang('City')}}</th>
                                        <td>
                                            <div><input readonly type="text" name="client_city" class="form-control text-center" value="{{get_client_city($model->client_id)}}"> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="50%">{{_lang('Note')}}</th>
                                        <td>
                                            <div><textarea name="note" id="note" class="form-control" cols="30" rows="2">{{$model->sell_note}}</textarea></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="40%">Ship To Another Address</th>
                                        <td class="text-center" width="60%">
                                            <input type="hidden" name="shipping_status" value="{{ $model->shipping_status }}">
                                            @if ($model->shipping_status == 'On')
                                                <span class="badge badge-danger">Yes</span>
                                            @else 
                                                <span class="badge badge-success">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($model->shipping_status == 'On')
                                        <tr>
                                            <th class="text-center">Shiping Client Full Name</th>
                                            <td class="text-center"><input type="text" name="ship_another_full_name" class="text-center form-control" placeholder="Enter Shiping Client Full Name" required value="{{ $model->full_name }}"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Shiping Client Email</th>
                                            <td class="text-center"><input type="text" name="ship_another_email" class="text-center form-control" placeholder="Enter Shiping Client Email" required value="{{ $model->email }}"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Shiping Client Phone</th>
                                            <td class="text-center"><input type="text" name="ship_another_phone" class="text-center form-control" placeholder="Enter Shiping Client Phone Number" required value="{{ $model->phone }}"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Shiping Client Address</th>
                                            <td class="text-center"><input type="text" name="ship_another_address" class="text-center form-control" placeholder="Enter Shiping Client Address" required value="{{ $model->address }}"></td>
                                        </tr>
    
                                        <tr>
                                            <th class="text-center">Shiping Client City</th>
                                            <td class="text-center"><input type="text" name="ship_another_city" class="text-center form-control" placeholder="Enter Shiping Client City Name" required value="{{ $model->city }}"></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
    
                            <div class="col-md-12 my-3">
                                <h4 class="text-center">Order Status Note</h4>
                                   <div class="row">
                                        @php
                                            $query = App\models\eCommerce\OrderStatus::where('transaction_id', $model->id)->get();
                                        @endphp
                                        @if (count($query))
                                            @foreach ($query as $element)
                                               
                                                <div class="card col-md-3 m-2">
                                                    <div class="card-header">{{ toWord($element->status) }}</div>
                                                    <div class="card-body"><b>Note : </b>{{ $element->note }} <br> <b>Updated User: </b> {{ $element->user ? $element->user->name : 'No User Found'}} </div>
                                                </div>
                                            @endforeach
                                        @else 
                                            <div class="col-md-12">
                                                <p class="text-center text-danger">No Order Status Note Found for this Transaction</p>
                                            </div>
                                        @endif
                                   </div>
                            </div>
    
                            {{-- Product List --}}
                            <div class="col-md-12 my-3">
                                <label for="name">{{_lang('Select Product')}}</label>
                                <input type="text" id="search_product" class="form-control" placeholder="Type Product Name">
                            </div>
                        </div>
                        
                        <div class="col-md-12 my-2 table-responsive">
                            <h4 class="text-center">Order Invoice</h4>
                            <table class="table table-bordered table-striped table-hover update_invoice_table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($sell_products as $item)
                                        @php
                                            $total += $item->total;
                                        @endphp
                                        <tr class="table_row_{{$item->id}}">
                                            <td><i data-id="{{ $item->id }}" style="cursor: pointer;" class="fa fa-trash text-danger delete_row text-center" aria-hidden="true"></i></td>
                                            <td>
                                                {{get_product_name($item->product_id)}} - {{get_product_color($item->variation_id)}} - {{get_product_size($item->variation_id)}}
                                                <input type="hidden" name="variation_id[]" value="{{$item->variation_id}}">
                                                <input type="hidden" name="product_id[]" value="{{$item->product_id}}">
                                            </td>
                                            <td><input autocomplete="off" type="text" name="quantity[]" class="form-control qty" value="{{round($item->quantity)}}"></td>
                                            <td>
                                                <input type="text" name="price[]" class="form-control price" value="{{round($item->unit_price)}}">
                                            </td>
                                            <td>
                                                <span class="sub_total_text">{{round($item->total)}}</span>
                                                <input type="hidden" name="sub_total[]"  class="sub_total" value="{{round($item->total)}}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">Subtotal</td>
                                        <td>
                                            <span id="show_subtotal">{{ number_format($total, 2) }}</span>                                        
                                            <input type="hidden" id="total_subtotal" name="subtotal" value="{{ $total }}">
                                        </td>
                                    </tr>
                                    <td colspan="4" class="text-right">Coupon Discount <b>{{ number_format($coupon_amount, 2) }}{{ $coupon_type == 'fixed' ? '+' : '%' }}</b> </td>
                                        <td>
                                            @php
                                                if ($coupon_type == 'fixed') {
                                                    $discount = $coupon_amount;
                                                } elseif($coupon_type == 'percentage') {
                                                    $discount = ($total * $coupon_amount) / 100 ;
                                                } else {
                                                    $discount = 0;
                                                }
                                            @endphp
                                            <span id="show_discount_amount">{{ number_format($discount, 2) }}</span>
                                            <input type="hidden" id="discount_type" value="{{ $coupon_type }}">
                                            <input type="hidden" name="discount" id="discount" value="0">
                                            <input type="hidden" id="total_discount" name="total_discount" value="{{ number_format($coupon_amount, 2) }}">
                                        </td>
                                    <tr>
                                        <td colspan="4" class="text-right">Total</td>
                                        <td>
                                            <span class="total_payable_amount">{{ number_format($total - $discount, 2) }}</span> 
                                            <input type="hidden" id="total_payable_amount" name="net_total" value="{{ $total }}">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Qurier --}}
                        <div class="col-md-12 form-group">
                            <label for="qurier_id">Select Qurier Service</label>
                            <select name="qurier_id" id="qurier_id" class="form-control select" data-placeholder="Select Qurier Service">
                                <option value="">Select Qurier Service</option>
                                @foreach ($quriers as $qurier)
                                    <option {{ $qurier->id == $model->qurier_id ? 'selected' : '' }} value="{{ $qurier->id }}">{{ $qurier->name }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        {{-- Order Note --}}
                        <div class="col-md-12 form-group">
                            <label for="order_note">Order Note</label>
                            <textarea required name="order_note" id="order_note" class="form-control" cols="30" rows="2" placeholder="Enter Order Note"></textarea>
                        </div>

                        {{-- Complain Note --}}
                        <div class="col-md-12 form-group">
                            <label for="complain_note">Complain Note</label>
                            <textarea name="complain_note" id="complain_note" class="form-control" cols="30" rows="2" placeholder="Enter Complain Note"></textarea>
                        </div>
    
                        {{-- Change Order Status --}}
                        {{-- {{ dd($model->ecommerce_status) }} --}}
                        @if ($model->ecommerce_status != 'success' && $model->ecommerce_status != 'return' && $model->ecommerce_status != 'payment_done')
                            <div class="col-md-12 form-group">
                                <label for="change_status">{{_lang('Change Order Status')}} </label>
                                <select data-parsley-errors-container="#change_order_status" data-url="{{route('admin.eCommerce.order.change_status')}}" name="status" id="status" class="form-control select" required data-placeholder="Select Status">
                                    <option value="">Select Status</option>
                                    <option {{ $model->ecommerce_status == 'pending' ? 'selected' : ''}} value="pending">{{_lang('Pending')}}</option>
                                    <option {{ $model->ecommerce_status == 'confirm' ? 'selected' : ''}} value="confirm">{{_lang('Confirm')}}</option>
                                    <option {{ $model->ecommerce_status == 'progressing' ? 'selected' : ''}} value="progressing">{{_lang('In Progressing')}}</option>
                                    <option {{ $model->ecommerce_status == 'shipment' ? 'selected' : ''}} value="shipment">{{_lang('In Shipment')}}</option>
                                    <option value="success">{{_lang('Success')}}</option>
                                    <option {{ $model->ecommerce_status == 'cancel' ? 'selected' : ''}} value="cancel">{{_lang('Cancel')}}</option>
                                    <option value="on_hold">{{_lang('On Hold')}}</option>
                                    <option value="payment_done">{{_lang('Payment Done')}}</option>
                                    <option value="return">{{_lang('Return')}}</option>
                                </select>
                                <span id="change_order_status"></span>
                            </div>

                            <div class="col-md-6 mx-auto">
                                <button type="submit" class="btn btn-success btn-block" id="submit">Update Invoice</button>
                            </div>
                        @else 
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" data-url="{{ route('admin.eCommerce.order.change_status') }}" data-id="{{ $model->id }}" class="btn btn-danger return btn-sm btn-block">Return</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" data-url="{{ route('admin.eCommerce.order.change_status') }}" data-id="{{ $model->id }}" class="btn btn-success payment_done btn-sm btn-block">Payment Done</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script>
    _formValidation();
    $('.select').select2({width:'100%'});
    // delete the row
    $(document).on('click', '.delete_row', function() {
        var row_id = $(this).data('id');

        $(".table_row_" + row_id).fadeOut('slow').remove();
        calc();
    });

    if ($('#search_product').length > 0) {
        $('#search_product')
            .autocomplete({
                source: '/admin/product/get_product',
                minLength: 2,
                response: function (event, ui) {
                    if (ui.content.length == 1) {
                        ui.item = ui.content[0];
                        $(this)
                            .data('ui-autocomplete')
                            ._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    } else if (ui.content.length == 0) {
                        var term = $(this).data('ui-autocomplete').term;
                        toastr.error('No Product Found', 'Opps!');
                    }
                },
                select: function (event, ui) {
                    $(this).val(null);
                    get_purchase_entry_row(ui.item.product_id, ui.item.variation_id);
                },
            })
            .autocomplete('instance')._renderItem = function (ul, item) {
            return $('<li>')
                .append('<div>' + item.text + '</div>')
                .appendTo(ul);
        };
    }

    function get_purchase_entry_row(product_id, variation_id) {
        //Get item addition method
        var is_added = false;
        //Search for variation id in each row of pos table
        $('#item')
            .find('tr')
            .each(function () {
                var row_v_id = $(this)
                    .find('.variation_id')
                    .val();
                if (
                    row_v_id == variation_id
                ) {
                    is_added = true;
                    //Increment product quantity
                    qty_element = $(this).find('.qty');
                    qty_element.val(parseInt(qty_element.val()) + 1);
                    update_sub_total($(this));
                    $('input#search_product')
                        .focus()
                        .select();
                }
            });


        if (!is_added && product_id) {
            var row_count = $('#row').val();
            $.ajax({
                method: 'POST',
                url: '/admin/production-work-order/append',
                dataType: 'json',
                data: {product_id: product_id, row_count: row_count, variation_id: variation_id},
                success: function (result) {
                    $('.update_invoice_table tbody').append(result.html);

                    if ($(result.html).find('.qty').length) {
                        $('#row').val(
                            $(result.html).find('.qty').length + parseInt(row_count)
                        ).trigger('change');
                    }
                    // var net_total = total_function();
                    // $('#refresh_net_total').html(net_total.toFixed(2));
                    // $('#net_total').val(net_total);
                    // $('#show_net_total').html(net_total.toFixed(2));
                    // $('.total_payable_amount').html(net_total.toFixed(2));
                    // $('#total_payable_amount').val(net_total.toFixed(2));

                    // console.log(sub);
                    var discount_amount = $('#total_discount').val();
                    var sub_total = total_function();
                    var discount_type = $('#discount_type').val();
                    $('#show_subtotal').text(sub_total.toFixed(2));
                    $('#total_subtotal').val(sub_total);
                    if(discount_type == 'fixed') {
                        discount = sub_total - discount_amount;
                    } else {
                        discount = (sub_total * discount_amount) / 100;
                    }

                    $('#show_discount_amount').text(discount.toFixed(2));

                    $('#discount').val(discount);


                    if(sub_total == '') {
                        sub_total = 0;
                    } else {
                        sub_total = parseInt(sub_total);
                    }

                    var total_payable = parseFloat(sub_total) - parseFloat(discount); 

                    console.log(total_payable);


                    $('.total_payable_amount').html(total_payable.toFixed(2));
                    $('#total_payable_amount').val(total_payable.toFixed(2));
                },
            });
        }

        // console.log(net_total);
    }

    $('.return').click(function() {
        var id = $(this).data('id');
        var url = $(this).data('url');
        $('.return').html('Please Wait ...');
        $('.return').attr('disabled', '1');
        val = 'return';
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                id: id, val:val
            },
            success: function (data) {
                if(data.status == 'success') {
                    toastr.success(data.message);
                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }
                }
                if(data.status == 'danger') {
                    toastr.error(data.message);
                }
                $('.return').html('Return');
                $('.return').removeAttr('disabled');
            }
        });
    });

    $('.payment_done').click(function() {
        var id = $(this).data('id');
        var url = $(this).data('url');
        $('.payment_done').html('Please Wait ...');
        $('.payment_done').attr('disabled', '1');
        val = 'payment_done';
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                id: id, val:val
            },
            success: function (data) {
                if(data.status == 'success') {
                    toastr.success(data.message);
                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }
                }
                if(data.status == 'danger') {
                    toastr.error(data.message);
                }
                $('.payment_done').html('Payment Done');
                $('.payment_done').removeAttr('disabled');
            }
        });
    });

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

    $(document).on('click', '.remove', function () {
        $(this).closest('tr').remove();
        $("#discount_amount").val("");
        $("#discount").val("");
        $("#paid").val("");
    });

    $(".update_invoice_table tbody tr").on('keyup change', '.qty, .price', function () {
        var tr = $(this).parent().parent();
        update_sub_total(tr);
        // console.log(sub);
        var discount_amount = $('#total_discount').val();
        var sub_total = total_function();
        var discount_type = $('#discount_type').val();
        $('#show_subtotal').text(sub_total.toFixed(2));
        $('#total_subtotal').val(sub_total);

        if(discount_type == 'fixed') {
            discount = sub_total - discount_amount;
        } else {
            discount = (sub_total * discount_amount) / 100;
        }
        $('#discount').val(discount);
        $('#show_discount_amount').text(discount.toFixed(2));


        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount); 

        console.log(total_payable);


        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    function update_sub_total(tr) {
        var qty = tr.find('.qty').val();
        var price = tr.find('.price').val();
        var total = qty * price;
        tr.find('.sub_total').val(total);
        // tr.find('.net_total').val(total);
        tr.find('.sub_total_text').text(total);
        // tr.find('.net_total_text').text(total);
    }
</script>
@endpush

