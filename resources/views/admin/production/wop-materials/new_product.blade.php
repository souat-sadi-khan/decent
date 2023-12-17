<div class="row">
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
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="wo_id" value="{{ $models->id }}">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    <input type="hidden" name="raw_material_id[]" value="{{ $item['material_id'] }}" class="form-control pid">
                                    {{ $item['material_name'] }}
                                </td>
                                <td>
                                    <div class="input-group">
                                    <input type="text" class="form-control qty" name="quantity[]" readonly
                                        value="{{ $item['qty'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="unit">{{$item['unit']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="price[]" value="{{ $item['price'] }}">
                                    <input type="text" readonly class="form-control" value="{{ number_format($item['price'], 2) }}">
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="total[]"  value="{{ $item['total'] }}">
                                    <input type="text" class="form-control" readonly  value="{{ number_format($item['total'], 2) }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>