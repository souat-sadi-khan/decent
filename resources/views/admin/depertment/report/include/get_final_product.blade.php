<table class="table table-bordered">
    <thead class="bg-green text-light">
        <tr>
            <td width="25%">{{ _lang('Name') }}</td>
            @foreach ($variations as $variation)
            <td width="8%">{{ $variation->name }}</td>
            @endforeach
            <td width="20%">{{ _lang('Request Qty') }}({{ _lang('Pair') }})</td>
            <td width="20%">{{ _lang('Done Qty') }}({{ _lang('Pair') }})</td>
            <td width="18%">{{ $depert_name->name }} {{ _lang('Qty') }}({{ _lang('Pair') }})</td>
        </tr>
    </thead>
    <tbody class="bg-gray">
        @foreach ($products as $product)
        <tr>
            <td>
                {{ get_product($product->product_id) }}
                {{ $product->variation->name }}
                <input type="hidden" name="name_product[]" value="{{ get_product($product->product_id) }}-{{ $product->variation->name }}">
                <input type="hidden" name="variation_id[]" value="{{ $product->variation_id }}">
                <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                <input type="hidden" name="done_depertment_id[]" value="{{ $product->id }}">
            </td>
            <td>{{ variation_value($product->variation->variation_value_id)}}</td>
            <td>{{ variation_value($product->variation->variation_value_id_2)}}</td>
            <td>
                <input type="text" class="form-control" value="{{ $product->qty  }}" readonly name="req_qty[]">
            </td>
            <td>
                <input type="text" class="form-control" name="done_qty[]" value=" {{ report_product_flow($depert_name->id,$product->work_order_id,$product->variation_id,$product->id) }}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="qty[]" value="{{ $product->qty-report_product_flow($depert_name->id,$product->work_order_id,$product->variation_id,$product->id) }}" required>
            </td>
        </tr>
        @endforeach
    </tbody>
    <input type="hidden" name="flow_type" value="final">
    <tfoot class="bg-gray">
    <tr>
        <td colspan="{{ $variations->count()+4 }}">
            <small class="text-danger">{{ _lang('If Submited Final Report Product Quantity add to stock value') }}</small> <br>
            @if ($products->count()>0)
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Send & Submit Final Report')}}</button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
            <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
            @endif
        </td>
    </tr>
    </tfoot>
</table>