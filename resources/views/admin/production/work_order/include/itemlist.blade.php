@foreach( $variations as $variation)
<tr>
    <td class="text-center">
        <i style="cursor: pointer;" class="fa fa-trash text-danger remove" aria-hidden="true"></i>
    </td>
    <td>
        {{ $product->name }} {{ $variation->name }} ({{$variation->sub_sku}})

        <input type="hidden" name="product_id[]" class="product_id" value="{{$product->id}}" data-variation="{{$variation->id}}">
    	<input type="hidden" name="variation_id[]" class="variation_id" value="{{$variation->id}}">
    	<input type="hidden" class="form-control code" id="code_{{$row}}" data-id="{{$row}}" value="{{$product->id}}">
    </td>

    <td>
    	<input type="text" autocomplete="off" name="quantity[]" class="form-control input_number qty" id="qty_{{$row}}" value="1">
    </td>
    <td>
    	<input type="text" autocomplete="off" name="price[]" class="form-control input_number price" value="{{$variation->default_sell_price}}">
    </td>
    <td>
        <input type="hidden" name="sub_total[]" class="sub_total" value="{{1*$variation->default_sell_price}}">
    	<span id="sub_total_{{$row}}" class="sub_total_text">{{1*$variation->default_sell_price}}</span>
	</td>
    
</tr>
@endforeach

{{-- <script>
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


        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount); 

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
</script> --}}