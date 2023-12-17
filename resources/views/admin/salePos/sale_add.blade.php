@extends('layouts.app', ['title' => _lang('New Sale'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="New Sale."><i class="fa fa-universal-access mr-4"></i> {{_lang('New Sale')}}</h1>
        <p>{{_lang('New Sale')}}</p>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <form action="{{route('admin.sale.pos.store')}}" method="post" enctype="multipart/form-data"  id="content_form">
                <input type="hidden" id="row" value="0">
                <div class="tile-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">{{ _lang('date') }} </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control date " id="date" name="date" value="{{ date('Y-m-d') }}" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">{{ _lang('Customer Type') }} </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                        <select name="sale_type" id="sale_type" class="form-control select">
                                            <option value="wholesale">Wholesale</option>
                                            <option value="retail">Retail sales</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">{{ _lang('Customer') }} </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-male" aria-hidden="true"></i></span>
                                        </div>
                                        <select name="client_id" class="form-control customer_id" id="customer_id" placeholder="Customer">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                        </div>
                                        <input type="text" class="form-control search_product " id="search_product" name="search_product" value="" placeholder="Scan Product">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pos_product_div">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%;">{{ _lang('Product') }}</th>
                                                    <th style="width: 15%;">{{ _lang('Qty') }}</th>
                                                    <th style="width: 15%;">{{ _lang('Price') }}</th>
                                                    <th style="width: 20%;">{{ _lang('Total') }}</th>
                                                    <th style="width: 10%;">{{ _lang('X') }}</th>
                                                </tr>
                                            </thead>
                                        <tbody id="item"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered border-dark" style="margin-bottom: 0px !important">
                            <tbody>
                                <tr>
                                    <td>
                                        <span>{{ _lang('Total Item') }}</span> <br>
                                        <input type="hidden" class="total_item">
                                        <span class="total_item">0</span>
                                    </td>
                                    <td>
                                        <span>{{ _lang('Total') }}</span> <br>
                                        <input type="hidden" name="sub_total" class="sub_total">
                                        <span class="sub_total">0</span>
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
                                        <input type="text" name="discount" class="form-control input_number" id="discount_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ _lang('Discount Value') }}</span> <br>
                                        <input type="text" name="discount_amount" class="form-control input_number" id="total_discount" readonly>
                                    </td>
                                    <td>
                                        <span>{{ _lang('Tax') }}</span> <br>
                                        <input type="text" name="tax" class="form-control input_number" id="tax_calculation_amount">
                                    </td>
                                    <td>
                                        <span>{{ _lang('Shipping') }}</span> <br>
                                        <input type="text" name="shipping_charges" class="form-control input_number" id="shipping_charges">
                                    </td>
                                    <td>
                                        <span>{{ _lang('Total Payable') }}</span> <br>
                                        <input type="hidden" class="form-control net_total" name="net_total">
                                        <span class="net_total"></span>
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
                                    <input type="text" class="form-control input_number paid" name="paid" id="paid">
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
                                {{ Form::label('method', _lang('Payment Account')) }}
                                {!! Form::select('account_id', $accounts,null, ['class' => 'form-control account_id select', 'required']); !!}
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
                   <div class="row mt-2">
                        <div class="col-md-6 mx-auto text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">{{ _lang('New Sale') }}</button>
                            <button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>
</div>
{{-- Contact Modal --}}
<div class="modal fade border-top-success rounded-top-0 contact_modal" role="dialog">
@include('admin.client.quick_add')
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    $('.account_id').select2();
    $('.select').select2();
        //get customer
    $('#customer_id').select2({
        ajax: {
            url: '/admin/client/customers',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function(data) {
                return {
                    results: data,
                };
            },
        },
        templateResult: function (data) { 
            return data.text + "<br>" + 'mobile' + ": " + data.mobile; 
        },
        minimumInputLength: 1,
        language: {
            noResults: function() {
                var name = $('#customer_id')
                    .data('select2')
                    .dropdown.$search.val();
                return (
                    '<button type="button" data-name="' +
                    name +
                    '" class="btn btn-link add_new_customer"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>&nbsp; ' +
                    'add_name_as_new_customer'+name +
                    '</button>'
                );
            },
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        width: '87.5%'
    });

    $(document).on('click', '.add_new_customer', function() {
        $('#customer_id').select2('close');
        var name = $(this).data('name');
        $('.contact_modal')
            .find('input#name')
            .val(name);
        $('.contact_modal')
            .find('select#contact_type')
            .val('customer')
            .closest('div.contact_type_div')
            .addClass('hide');
        $('.contact_modal').modal('show');
    });

    $('.contact_modal').on('hidden.bs.modal', function() {
        $('form.quick_add_contact')
            .find('button[type="submit"]')
            .removeAttr('disabled');
        $('form.quick_add_contact')[0].reset();
    });
    _remortFormValidation();


$('select#sale_type').on('change',function(){
   $('#item').html('');
   calculate();
});
        //Add Product
    $('#search_product')
        .autocomplete({
            source: function(request, response) {
                 $.getJSON(
                    '/admin/products/list',
                    {
                        brand_id: $('input#brand_id').val(),
                        sale_type: $('select#sale_type').val(),
                        term: request.term,
                    },
                    response
                );
            },
            minLength: 2,
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    ui.item = ui.content[0];
                    if (ui.item.qty > 0) {
                        $(this)
                            .data('ui-autocomplete')
                            ._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    }
                } else if (ui.content.length == 0) {
                      swal("Oops", "Out Off Stock", "error");
                    $('input#search_product').select();
                }
            },
            focus: function(event, ui) {
                if (ui.item.qty <= 0) {
                    return false;
                }
            },
            select: function(event, ui) {
                if ( ui.item.qty > 0) {
                    $(this).val(null);
                     item1(ui.item, ui.item.variation_id, 1,$('select#sale_type').val());
                } else {
                    toastr.error('Out of Stock');
                }
            },
        })
        // .autocomplete('instance')._renderItem = function(ul, item) {
        //     return $('<li>')
        //         .append('<div>' + item.name + '</div>')
        //         .appendTo(ul);
        // };

        .autocomplete('instance')._renderItem = function(ul, item) {
        if (item.qty <= 0) {
            var string = '<li class="ui-state-disabled">' + item.name;
                string += '-' + item.variation;
        
            var selling_price = item.selling_price;
            string +=
                ' (' +
                item.sku +
                ')' +
                '<br> Price: ' +
                selling_price +
                ' (Out of stock) </li>';
            return $(string).appendTo(ul);
        } else {
            var string = '<div>' + item.name;
                string += '-' + item.variation;
            var selling_price = item.selling_price;
            string += ' (' + item.sku + ')' + '<br> Price: ' + selling_price;
            string += '</div>';
            return $('<li>')
                .append(string)
                .appendTo(ul);
        }
    };

    //add row function
function item1(item, variation_id, quantity,sale_type) {
    var tr = $("#item").parent().parent();
    var a = tr.find('.code');
    if (a.length == 0) {
        var row = parseInt($("#row").val());
        $.ajax({
            type: 'GET',
            url: "/admin/sale/pos/scannerappend1",
            data: {
                variation_id: variation_id,
                row: row,
                quantity: quantity,
                sale_type: sale_type,
            },
            dateType: 'html',
            success: function(data) {
                $("#item").append(data);
                $('#row').val(row + 1);
                calculate();
            }
        });
    } else {
        var found = true;
        $(".code").each(function() {
            if ($(this).val() == item.sku) {
                    var id = $(this).data('id');
                    var qty = parseFloat($('#qty_' + id).val());
                    parseFloat($('#qty_' + id).val(qty + quantity));
                    var nwqty = parseFloat($('#qty_' + id).val());
                    var amt = nwqty * parseFloat(item.selling_price);
                    $("#amt_" + id).html(amt);
                    calculate();
                    found = false;
                    return false;

            }
        })
        if (found) {
            var row = parseInt($("#row").val());
            $.ajax({
                type: 'GET',
                url: "/admin/sale/pos/scannerappend1",
                data: {
                    variation_id: variation_id,
                    row: row,
                    quantity: quantity,
                    sale_type: sale_type,
                },
                dateType: 'html',
                success: function(data) {
                    $("#item").append(data);
                    $('#row').val(row + 1);
                    calculate();
                }
            });
        }
    }
}

$("#item").on('click', '.btn_remove', function() {
    $(this).closest('tr').remove();
    calculate();
})

   function calculate() {
        var sub_total = 0;
        var shipping_charges=0;
        var qty = 0;
        $(".amt").each(function() {
            sub_total = sub_total + ($(this).html() * 1);
        })

        $(".qty").each(function() {
            qty = qty + ($(this).val() * 1);
        })

        $(".total_item").val(qty);
        $(".total_item").text(qty);
          net_total = sub_total;
        $(".sub_total").val(sub_total);
        $(".sub_total").text(sub_total);
        var discount =pos_discount(sub_total);
        net_total =sub_total-discount;

        var tax =pos_order_tax(net_total,discount);
        net_total =net_total+tax;

        shipping_charges =shipping();
        net_total =net_total+shipping_charges;

        $(".net_total").val(net_total);
        $(".net_total").text(net_total);
        $("#due").val(net_total);
        var change_amount =calculate_balance_due(net_total);
        $('.change_return_span').text(change_amount);
        $('#due').val(change_amount);
         
    }


    $("#discount_amount, #discount_type,#tax_calculation_amount,#shipping_charges,#paid").on('keyup blur change', function () {
       calculate();
    });


 function pos_discount(total_amount) {
    var calculation_type = $('#discount_type').val();
    var calculation_amount = __read_number($('#discount_amount'));

    var discount = __calculate_amount(calculation_type, calculation_amount, total_amount);

    $('#total_discount').val(discount, false);

    return discount;
}

function __read_number(input_element, use_page_currency = false) {
    return input_element.val();
}

function pos_order_tax(price_total, discount) {
    var calculation_type = 'percentage';
    var calculation_amount = __read_number($('#tax_calculation_amount'));
    var total_amount = price_total;

    var order_tax = __calculate_amount(calculation_type, calculation_amount, total_amount);


    $('span#order_tax').text(order_tax, false);
    return order_tax;
}

function shipping()
{
  var shipping_charges =parseFloat($('#shipping_charges').val()); 
  return isNaN(shipping_charges) ? 0 : shipping_charges;;
   
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


function calculate_balance_due(total) {
    var paid =parseFloat($('#paid').val());
    paid=isNaN(paid) ? 0 : paid;
    $('.total_paying').text(paid);
    var total_change =total-paid;
    return total_change;
}


$(document).on('change','.method',function(){
    var method =$(".method").val();
    if (method=='cash') {
        $('.reference_no').hide(300);
    }
    else
    {
      $('.reference_no').show(400);  
    }
});

$("#item").delegate(".qty,.sale_price", "keyup", function() {
    var tr = $(this).parent().parent();
    tr.find(".amt").html(tr.find(".qty").val() * tr.find(".sale_price").val());
    calculate();


})
_componentDatefPicker();
_formValidation();
</script>
@endpush