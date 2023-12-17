@php
    $id = $row;
    $product_name = $product->name;
    $sell_price = $variation->default_sell_price;
@endphp
<tr id="table_row_{{$id}}">
    <td width="2%">
        {{ $id }}
        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
        <input type="hidden" name="variation_id[]" value="{{ $variation->id }}">
    </td>

    <!-- Product Image -->
    <td>
        <img src="{{ $photo != '' ? asset('storage/product'. '/'. $photo) : asset('img/product.jpg') }}" style="width: 100px;" alt="">
    </td>

    <!-- Product Name -->
    <td>
        {{ $product->name }} <br>
        {{ $variation->name }}
    </td>

    <!-- Product Discount Type -->
    <td>
        <select data-id="{{ $variation->id }}" name="discount_type[]" id="discount_type_{{$variation->id}}" class="form-control discount_type select" data-placeholder="Select Discount Type" required >
            <option value="">Select Discount Type</option>
            <option selected value="Percentages">Percentages</option>
            <option value="Addition">Addition</option>
        </select>
    </td>

    <!-- Discount Amount -->
    <td>
        <input data-id="{{ $variation->id }}" type="text" autocomplete="off" name="discount[]" id="discount_{{$variation->id }}" class="form-control discount" placeholder="Discunt Amount" value="0">
    </td>

    <!-- Sell Price -->
    <td>
        {{ get_option('currency') }} <span id="show_sell_price_{{ $variation->id }}"> {{ $sell_price }}</span>
        <input type="hidden" id="main_price_{{$variation->id}}" value="{{ $sell_price }}">
        <input type="hidden" name="price_with_dis[]" id="price_with_dis_{{ $variation->id }}" value="{{ $sell_price }}">
        <input type="hidden" name="price_without_dis[]" id="price_without_dis_{{ $variation->id }}" value="{{ $sell_price }}">
    </td>

    <!-- Delete The Row -->
    <td>
        <i class="fa text-danger delete_row fa-trash" style="cursor: pointer;" data-id="{{ $id }}" aria-hidden="true"></i>
    </td>


</tr>

<script>
    $('.select').select2({width:'100%'});

    $('.discount').keyup(function() {
        var id = $(this).data('id');
        var dis_amount = $('#discount_'+id).val();
        var discount_type = $('#discount_type_'+id).val();

        console.log(id);
        if(discount_type == 'Percentages') {
            var dis_amount = parseInt(dis_amount);

            var price = parseInt($('#main_price_'+id).val());

            var discount = (price * dis_amount) / 100;
            
            var main_price = price - discount;

        } else {
            var dis_amount = parseInt(dis_amount);
            var price = parseInt($('#main_price_'+id).val());
            
            var main_price = price - dis_amount;
        }

        $('#show_sell_price_'+id).html(main_price);
        $('#price_with_dis_'+id).val(main_price); 
    });

    $('.discount_type').change(function() {
        var id = $(this).data('id');
        var dis_amount = $('#discount_'+id).val(); 
        var discount_type = $(this).val();

        if(discount_type == 'Percentages') {
            var dis_amount = parseInt(dis_amount);
            var price = parseInt($('#main_price_'+id).val());

            var discount = (price * dis_amount) / 100;
            
            var main_price = price - discount;
        } else {
            var dis_amount = parseInt(dis_amount);
            var price = parseInt($('#main_price_'+id).val());
            
            var main_price = price - dis_amount;
        }

        $('#show_sell_price_'+id).html(main_price);
        $('#price_with_dis_'+id).val(main_price); 
    });

</script>