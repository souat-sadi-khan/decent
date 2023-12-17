<tr>
    <td>
    <input type="text" name="variation[sub_sku][{{$row}}]" class="form-control" value="{{ $model->articel }}-{{$row}}"
            >
    <input type="hidden" name="variation[default_sell_price][{{$row}}]" class="form-control" value="0.00">
    <input type="hidden" name="variation[default_purchase_price][{{$row}}]" class="form-control" value="0.00">
    </td>
    @foreach ($variations as $item)
    <td>
        <select data-placeholder="Variation Value" name="variation[variation_value_id][{{$row}}][{{$loop->index}}]" id="raw_status" required class="form-control">
            <option value="">Select Variation</option>
            @php
                $query = App\models\Production\VariationTemplateDetails::where('variation_template_id', $item->id)->where('category_id', NULL)->get();
            @endphp
        
            @foreach ($query as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
            
            @php
                $query = App\models\Production\VariationTemplateDetails::where('variation_template_id', $item->id)->where('category_id', $model->category_id)->get();
            @endphp
        
            @foreach ($query as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select> 
    </td>
    @endforeach
   {{--  <td>
        <input type="text" name="variation[default_purchase_price][{{$row}}]" class="form-control" value="">
    </td>
    <td>
        <input type="text" name="variation[default_sell_price][{{$row}}]" class="form-control" value="">
    </td> --}}
    <td>
        <button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
    </td>
</tr>
