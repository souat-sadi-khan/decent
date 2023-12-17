    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-green text-light">
                    <tr>
                        <td>{{ _lang('Name') }}</td>
                        @foreach ($variations as $variation)
                        <td>{{ $variation->name }}</td>
                        @endforeach
                        <td>{{ _lang('Job Qty') }}</td>
                    </tr>
                </thead>
                <tbody class="bg-gray" id="table_grid">
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            {{ $product->name }}
                            <input type="hidden" name="variation_id[]" value="{{ $product->id }}">
                            <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                        </td>
                        <td>{{ variation_value($product->variation_value_id)}}</td>
                        <td>{{ variation_value($product->variation_value_id_2)}}</td>
                        <td>
                            <input type="text" class="form-control input_number qty" name="qty[]">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="sub_total">{{ _lang('Sub Total') }} </label>
                <input type="text" class="form-control input_number sub_total" name="sub_total" id="sub_total">
                <input type="hidden" name="hidden_qty" id="hidden_qty">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_charges">{{ _lang('Shipping Charge') }} </label>
                <input type="text" name="shipping_charges" class="form-control input_number" id="shipping_charges">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="net_total">{{ _lang('Net Total') }} </label>
                <input type="text" name="net_total" class="form-control input_number" id="net_total" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="paid">{{ _lang('Paid') }} </label>
                <input type="text" class="form-control input_number paid" name="paid" id="paid">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="due">{{ _lang('Due') }} </label>
                <input type="text" class="form-control input_number due" name="due" id="due" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="due">{{ _lang('Pay Account') }} </label>
                <select name="investment_account_id" id="investment_account_id" class="form-control select">
                    <option value="">Select Account</option>
                    @foreach ($inves_account as $element)
                        <option value="{{ $element->id }}">{{ $element->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="job_work_reason">{{ _lang('Reason') }} </label>
            <textarea name="job_work_reason" class="form-control" id="job_work_reason" placeholder="Job Reason"></textarea>
        </div>
        <div class="col-md-6">
            <label for="job_work_company">{{ _lang('Job Order Company') }} </label>
            <textarea name="job_work_company" class="form-control" id="job_work_company" placeholder="Job Order Company details"></textarea>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 mx-auto text-center">
            <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">{{ _lang('Job Work') }}</button>
            <button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
<script>
calculate();

function calculate() {
    var shipping_charges = 0;
    var qty = 0;
    $(".qty").each(function() {
      qty = qty + ($(this).val() * 1);
    })
    var sub_total = subb_total();
    var net_total = sub_total;
    shipping_charges = shipping();
    net_total = net_total + shipping_charges;
    $("#net_total").val(net_total);
    $("#due").val(net_total);
    $("#hidden_qty").val(qty);
    var change_amount = calculate_balance_due(net_total);
    $('#due').val(change_amount);
}

function subb_total() {
    var sub = parseFloat($('#sub_total').val());
    return isNaN(sub) ? 0 : sub;;
}

function shipping() {
    var shipping_charges = parseFloat($('#shipping_charges').val());
    return isNaN(shipping_charges) ? 0 : shipping_charges;;
}

function calculate_balance_due(total) {
    var paid = parseFloat($('#paid').val());
    paid = isNaN(paid) ? 0 : paid;
    var total_change = total - paid;
    return total_change;
}
$("#sub_total,#shipping_charges,#paid").on('keyup blur change', function() {
    calculate();
});

$("#table_grid").delegate(".qty", "keyup", function() {
    calculate();


})
</script>