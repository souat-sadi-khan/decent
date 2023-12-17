@extends('layouts.app', ['title' => _lang('Production to eCommerce'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Production to eCommerce."><i class="fa fa-universal-access mr-4"></i>
                {{_lang('Production to eCommerce')}}</h1>
        </div>
    </div>
@stop

{{-- Main Section --}}
@section('content')
    <!-- Basic initialization -->
    <form action="{{route('admin.eCommerce.production-to-ecommerce.store')}}" method="post" id="content_form"
          enctype="multipart/form-data">
        @csrf
        <div class="card">
            {{-- Select Product  --}}
            <div class="col-md-12 my-3">
                <label for="name">{{_lang('Select Product')}}</label>
                <input type="text" id="search_product" class="form-control" placeholder="Type Product Name">
            </div>

            <div class="col-md-12 my-2 table-responsive">
                <h4 class="text-center">Transafer Product Stock</h4>
                <table class="table table-bordered table-striped table-hover update_invoice_table">
                    <thead>
                        <tr>
                            <th><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></th>
                            <th>Product Name</th>
                            <th>Avaiable Quantity</th>
                            <th>Pass Quantity</th>
                            <th>Price (1 Unit)</th>
                        </tr>
                    </thead>
                    <tbody id="item">
                       
                    </tbody>
                </table>
            </div>

            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                        class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-info" id="submiting"
                        style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
    <!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script>
    _formValidation();
           //Add Product
           $('#search_product')
           .autocomplete({
               source: function(request, response) {
                    $.getJSON(
                       '/admin/products/list',
                       {
                           brand_id: $('input#brand_id').val(),
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
                         swal("Oops", "Product not Found", "error");
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
                        item1(ui.item, ui.item.variation_id, 1);
                   } else {
                       toastr.error('Product not Found!');
                   }
               },
           })
   
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
function item1(item, variation_id, quantity) {
    var tr = $("#item").parent().parent();
    var a = tr.find('.code');
    if (a.length == 0) {
        var row = parseInt($("#row").val());
        var page = 'ecommerce';
        var action = 'create';
        $.ajax({
            type: 'GET',
            url: "/admin/sale/pos/scannerappend1",
            data: {
                variation_id: variation_id,
                row: row,
                quantity: quantity,
                page: page,
                action: action,
            },
            dateType: 'html',
            success: function(data) {
                $(".update_invoice_table").append(data);
                $('#row').val(row + 1);
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
                    found = false;
                    return false;

            }
        })
        if (found) {
            var row = parseInt($("#row").val());
            var page = 'ecommerce';
            var action = 'create';
            $.ajax({
                type: 'GET',
                url: "/admin/sale/pos/scannerappend1",
                data: {
                    variation_id: variation_id,
                    row: row,
                    quantity: quantity,
                    page: page,
                    action: action,
                },
                dateType: 'html',
                success: function(data) {
                    $(".update_invoice_table").append(data);
                    $('#row').val(row + 1);
                }
            });
        }
    }
}

$("#item").on('click', '.btn_remove', function() {
    $(this).closest('tr').remove();
})
</script>
@endpush