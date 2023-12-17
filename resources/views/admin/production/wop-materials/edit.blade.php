@extends('layouts.app', ['title' => _lang('Work Order Product Materials'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('WOP Materials Edit')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('wop-materials-edit') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-wop-materials.update', $models->id)}}" method="post" id="content_form">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Edit Work Order Product Materials')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Select Parent Catagory --}}
                <div class="col-md-6 mx-auto">
                    <label for="catagory_id">{{_lang('Select Work Order')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control" readonly name="wo_id" id="catagory_id"
                            data-url='{{route('admin.wop-materials.product')}}' class="form-control select">
                            <option value="{{$models->id}}">{{$models->prefix}}-{{$models->code}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" id="data">
            @foreach ($models->work_order as $work_order_product)
            <div class="row">
                <div class="col-md-12">
                    <p class="h4 pt-4">{{_lang('Product')}} : <span class="">{{$work_order_product->product->name}}
                            ({{$work_order_product->product->articel}})</span></p>
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

                                    @php
                                        $wop_id = $work_order_product->id;
                                        $raw_material_id = $item->material_id;
                                        $wo_id = $id;
                                        $value = App\models\Production\WopMaterial::where('wo_id',$wo_id)->where('wop_id',$wop_id)->where('raw_material_id',$raw_material_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>
                                            <input type="hidden"
                                                name="raw_material[{{$work_order_product->id}}][{{$item->id}}][raw_material_id]"
                                                value="{{ $item->material_id }}" class="form-control pid">
                                            {{ $item->material->name }}
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control qty qty_{{$item->id}}"
                                                    id="{{$item->id}}"
                                                    name="raw_material[{{$work_order_product->id}}][{{$item->id}}][qty]"
                                                    value="{{ $value->qty }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"
                                                        id="unit">{{$item->unit->unit}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control unit_price"
                                                id="unit_price_{{$item->id}}" data-id="{{$item->id}}"
                                                name="raw_material[{{$work_order_product->id}}][{{$item->id}}][unit_price]"
                                                value="{{ $value->unit_price }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control price" id="price_{{$item->id}}"
                                                readonly
                                                name="raw_material[{{$work_order_product->id}}][{{$item->id}}][price]"
                                                value="{{ $value->price }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control waste" maxlength="2"
                                                id="{{$item->id}}"
                                                name="raw_material[{{$work_order_product->id}}][{{$item->id}}][waste]"
                                                value="{{ $value->waste }}">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control uses"
                                                id="uses_{{$item->id}}"
                                                name="raw_material[{{$work_order_product->id}}][{{$item->id}}][uses]"
                                                value="{{ $value->uses }}">
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

        </div>

        <div class="form-group col-md-12" id="submit_btn" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Update')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('js/production/wop-materials.js') }}"></script>
<script>
    $(".qty").on('keyup', function (e) {
        var id = $(this).attr('id');
        var qty = $(this).val();
        var unit_price = $('#unit_price_' + id).val();
        var total = parseInt(qty) * parseInt(unit_price);
        $("#price_" + id).val(total);
    });

    $(".unit_price").on('keyup', function (e) {
        var id = $(this).data('id');
        var unit_price = $(this).val();
        var qty = $('.qty_' + id).val();
        var total = parseInt(qty) * parseInt(unit_price);
        $("#price_" + id).val(total);
    });


    $(".waste").on('keyup', function (e) {
        var id = $(this).attr('id');
        var a = $(this).val();
        var total = 100 - a;
        $("#uses_" + id).val(total);
    });

</script>
@endpush
