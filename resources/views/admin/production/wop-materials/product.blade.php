@foreach ($models->workOrderProduct as $work_order_product)
<div class="row">
    <div class="col-md-12">
        <p class="h4 pt-4">{{_lang('Product')}} : <span class="">{{$work_order_product->product->name}} ({{$work_order_product->product->articel}})</span></p>
    </div>
    <div class="col-md-12">
        <div class="p-20">
            <div class="table-responsive">
                <table class="table table-bordered m-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>{{ _lang('Raw Material') }}</th>
                            <th>{{ _lang('Quantity') }}</th>
                            <th>{{ _lang('Price') }}</th>
                            <th>{{ _lang('Total Price') }}</th>
                            <th>{{ _lang('Waste') }}</th>
                            <th>{{ _lang('Uses') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($work_order_product->product->material as $item)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                <input type="hidden" name="raw_material[{{$work_order_product->id}}][{{$item->id}}][raw_material_id]" value="{{ $item->material_id }}" class="form-control pid">
                                {{ $item->material->name }}
                            </td>
                            <td>
                                <div class="input-group">
                                <input type="text" class="form-control qty qty_{{$item->id}}" id="{{$item->id}}" name="raw_material[{{$work_order_product->id}}][{{$item->id}}][qty]"
                                    value="{{ $work_order_product->qty }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="unit">{{$item->unit->unit}}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control unit_price" id="unit_price_{{$item->id}}"
                                    data-id="{{$item->id}}" name="raw_material[{{$work_order_product->id}}][{{$item->id}}][unit_price]" value="{{ $work_order_product->price }}">
                            </td>
                            <td>
                                <input type="text" class="form-control price" id="price_{{$item->id}}" readonly name="raw_material[{{$work_order_product->id}}][{{$item->id}}][price]"
                                    value="{{ $work_order_product->sub_total }}">
                            </td>
                            <td>
                                <div class="input-group">
                                <input type="number" class="form-control waste" maxlength="2" id="{{$item->id}}" name="raw_material[{{$work_order_product->id}}][{{$item->id}}][waste]"
                                    value="{{ $item->waste }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" >%</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                <input type="text" readonly class="form-control uses" id="uses_{{$item->id}}" name="raw_material[{{$work_order_product->id}}][{{$item->id}}][uses]"
                                    value="{{ $item->uses }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" >%</span>
                                    </div>
                                </div>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
$(".qty").on('keyup', function (e) {
    var id = $(this).attr('id');
    var qty = $(this).val();
    var unit_price = $('#unit_price_'+id).val();
    var total = parseInt(qty) * parseInt(unit_price);
    $("#price_"+id).val(total);
});

$(".unit_price").on('keyup', function (e) {
    var id = $(this).data('id');
    var unit_price = $(this).val();
    var qty = $('.qty_'+id).val();
    var total = parseInt(qty) * parseInt(unit_price);
    $("#price_"+id).val(total);
});

    $(".waste").on('keyup', function (e) {
    var id = $(this).attr('id');
    var a = $(this).val();
    var total = 100 - a;
    $("#uses_"+id).val(total);
});
</script>
