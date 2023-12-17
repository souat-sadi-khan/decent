<table class="table table-bordered">
    <thead class="bg-green text-light">
        <tr>
            <td>{{ _lang('Name') }}</td>
            @foreach ($variations as $variation)
            <td>{{ $variation->name }}</td>
            @endforeach
            <td>{{ $depert_name->name }} {{ _lang('Qty') }}({{ _lang('Pair') }})</td>
        </tr>
    </thead>
        <tbody class="bg-gray">
            @foreach ($products as $product)
            <tr>
                <td>
                    {{ get_product($product->product_id) }}
                    {{ $product->name }}
                    <input type="hidden" name="variation_id[]" value="{{ $product->id }}">
                    <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                </td>
                <td>{{ variation_value($product->variation_value_id)}}</td>
                <td>{{ variation_value($product->variation_value_id_2)}}</td>
                <td>
                    <input type="text" class="form-control" name="qty[]" required>
                </td>
            </tr>
            @endforeach
        </tbody>
        <input type="hidden" name="flow_type" value="First">
    <tfoot class="bg-gray">
    <tr>
        <td colspan="{{ $variations->count()+1 }}">
            <label for="">{{ _lang('Sending Depertment') }}</label> <br>
            <select class="form-control select_custom" data-placeholder="Select Depertment" name="send_depertment_id" required>
                <option value="">Select One</option>
                @foreach ($depertments as $depertment_value)
                <option value="{{ $depertment_value->id }}">{{ $depertment_value->name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            @if ($products->count()>0)
            <br>
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Send & Submit Report')}}</button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
            <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
            @endif
        </td>
    </tr>
    </tfoot>
</table>