@extends('layouts.app', ['title' => _lang('Sale Pos'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
<style>

.table th, .table td {
    padding: 0.2rem 0.5rem;
}

.pos_product_div .form-control{
  padding: 0.1rem 0.65rem;
}

.btn-sm, .btn-group-sm > .btn{
        padding: 0rem 0.5rem;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #797979;
}

.product_box.bg-white.add_product.border-0.rounded {
    box-shadow: 0px 0px 5px #00000042;
}


</style>
@endpush
@section('page.header')
<div class="app-title">
	<div>
		<h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
		{{_lang('Sale Pos')}}</h1>
	</div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="tile">
	<div class="tile-body">
		<form action="{{route('admin.sale.pos.store')}}" method="post" enctype="multipart/form-data" target="_blank" id="content_form">
            <input type="hidden" id="row" value="0">
			<div class="row">
				<div class="col-md-7">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                 <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                             </div>
                            <input type="text" class="form-control date " id="date" name="date" value="{{ date('Y-m-d') }}" placeholder="Date">
                         </div>
                      </div>
                        <div class="col-md-6">
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
                      <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                 <span class="input-group-text"><i class="fa fa-male" aria-hidden="true"></i></span>
                             </div>
                            <select name="client_id" class="form-control customer_id" id="customer_id" data-placeholder="Select Customer" >
                            </select>
                         </div>
                      </div>
                      <div class="col-md-6">
                          <div class="input-group mb-3">
                            <div class="input-group-append">
                                 <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                             </div>
                            <input type="text" class="form-control search_product " id="search_product" name="search_product" value="" placeholder="Scan Product">
                         </div>
                      </div>
                      <div class="col-md-12">
                             <div class="card">
                                <div class="card-body p-2">
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
                      <div class="col-md-12">
                          @include('admin.salePos.partials.pos_details')
                      </div>
                  </div>
                </div>
				<div class="col-md-5">
					<div class="card">
						<div class="crad-body">
							<div class="row">
								<div class="col-md-6 ">
                                    <div class="form-group">
								    <select name="category_id" id="category_id" class="form-control select" data-url='{{route('admin.production-product.category')}}'>
                                        <option value="">All Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
								</div>
								<div class="col-md-6 ">
                                    <div class="form-group">
									<select name="sub_category_id" id="sub_category_id" class="form-control select">
									<option value="">All Subcategory</option>
									</select>
                                </div>
								</div>
							</div>
							<input type="hidden" id="suggestion_page" value="1">
							<div class="row">
								<div class="col-md-12">
									<div class="eq-height-row" id="product_list_body"></div>
								</div>
								<div class="col-md-12 text-center" id="suggestion_page_loader" style="display: none;">
									<i class="fa fa-spinner fa-spin fa-2x"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            @include('admin.salePos.partials.payment_modal')
		</form>
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
	$('.select').select2();

	    //Show product list.
    get_product_suggestion_list(
        $('select#category_id').val(),
        $('select#brand_id').val(),
        $('select#sale_type').val(),
    );

	$('div#product_list_body').on('scroll', function() {
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        var page = parseInt($('#suggestion_page').val());
        page += 1;
        $('#suggestion_page').val(page);
        var category_id = $('select#category_id').val();
        var sub_category_id = $('select#sub_category_id').val();
        var sale_type = $('select#sale_type').val();

        get_product_suggestion_list(category_id, sub_category_id,sale_type);
    }
});

	$('select#category_id, select#sub_category_id, select#sale_type').on('change', function(e) {
        $('input#suggestion_page').val(1);
            get_product_suggestion_list(
                $('select#category_id').val(),
                $('select#sub_category_id').val(),
                $('select#sale_type').val(),
                null
            );

    });

$('select#sale_type').on('change',function(){
   $('#item').html('');
   calculate();
});

 function get_product_suggestion_list(category_id, sub_category_id,sale_type, url = null,term=null) {

    if($('div#product_list_body').length == 0) {
        return false;
    }

    if (url == null) {
        url = '/admin/sale/pos/get-product-suggestion';
    }
    $('#suggestion_page_loader').fadeIn(700);
    var page = $('input#suggestion_page').val();
    if (page == 1) {
        $('div#product_list_body').html('');
    }
    if ($('div#product_list_body').find('input#no_products_found').length > 0) {
        $('#suggestion_page_loader').fadeOut(700);
        return false;
    }
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            category_id: category_id,
            sub_category_id: sub_category_id,
            sale_type: sale_type,
            page: page,
            term:term
        },
        dataType: 'html',
        success: function(result) {
            $('div#product_list_body').append(result);
            $('#suggestion_page_loader').fadeOut(700);
        },
    });
}

// add row to click
$(document).delegate(".add_product", "click", function(e) {
    var variation_id = $(this).data('variation_id');
    var url = $(this).data('url');
    var quantity = parseInt($(this).data('qty'));
    var sale_type = $('#sale_type').val();
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            variation_id: variation_id
        },
        dateType: 'json',
        success: function(data) {
            item1(data.product, variation_id, quantity,sale_type);

        }
    });
});
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
                    console.log(ui);
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
        $('#tax_amount').val(tax);
        net_total =net_total+tax;

        shipping_charges =shipping();
        net_total =net_total+shipping_charges;

        $(".net_total").val(net_total);
        $(".net_total").text(net_total);
        $(".due").val(net_total);
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

$(document).on('click','#payment_modal',function(){

    var qty =$('.total_item').val();
    if (qty =="" || qty==0) {
     swal("Oops", "Something Wrong", "error");
        $('#paymentModal').modal('hide');
    }
    else
    {
     $('#paymentModal').modal('show');
    }
});

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

$("#item").delegate(".qty,.sale_price", "keyup blur change", function() {
    var tr = $(this).parent().parent();
    var qty =tr.find('.qty');
    var able =tr.find('input.tqty').val();
   if ((qty.val() -0) > (tr.find(".tqty").val()-0)) {
     toastr.error('Sorry! this much not quantity is not available! available Qty is :'+' '+able);
      qty.val(1).change();
    }
    else{
        tr.find(".amt").html(qty.val() * tr.find(".sale_price").val());
      calculate();
    }


})

$(document).on('change', '#category_id', function () {
    // it will get action url
    var url = $(this).data('url');
    var id = $(this).val();

    $.ajax({
            url: url,
            data: {
                id: id
            },
            type: 'Get',
            dataType: 'json'
        })
        .done(function (data) {
            console.log(data);
            $('#sub_category_id').html("");
            $('#sub_category_id').append($('<option>').text("All SubCategory").attr('value', ""));
            $.each(data, function (i, parts) {
                $('#sub_category_id').append($('<option>').text(parts.name).attr('value', parts.id));
            });
        })
});
_componentDatefPicker();
_formValidation();
</script>
@endpush
