@extends('layouts.app', ['title' => _lang('Production Product Variation'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Variation Product for Production."><i
                class="fa fa-universal-access mr-4"></i>
            {{_lang('Production Product Create')}}</h1>
        <p>{{_lang('Variation Product for Production.')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('product-create') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-product.variation-store')}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf

    @php
    $model = App\models\Production\Product::findOrFail($id);
    $variations = App\models\Production\VariationTemplate::all();
    @endphp
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Add Variation For Product')}}</h6>
        </div>
        <div class="card-body">
            <div class="p-20">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th>
                                    <input type="hidden" name="row" class="form-control" id="row" value="0">
                                    <input type="hidden" name="product_id" class="form-control" value="{{ $model->id }}">
                                    {{_lang('Sub Sku')}}
                                </th>
                                @foreach ($variations as $item)
                                    <th>
                                        <input type="hidden" name="variation[varitaion_template_id][{{$loop->index}}]" value="{{$item->id}}">
                                        {{ $item->name }}
                                    </th>
                                @endforeach
                               {{--  <th>
                                    {{_lang('Purchase Price')}}
                                </th>
                                <th>
                                    {{_lang('Sell Price')}}
                                </th> --}}
                                <th width="10%">
                                    <a data-placement="bottom" id="addVariation" title="Add More Variation Product" type="button" class="btn btn-success text-light" data-url="{{ route('admin.production-product.variation_add', $model->id) }}"><i class="fa fa-plus-square mr-2"
                                            aria-hidden="true"></i></i>{{_lang('Add')}}</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <tr>
                                <td>
                                    <input type="text" name="variation[sub_sku][0]" class="form-control" value="{{ $model->articel }}-0">
                                    <input type="hidden" name="variation[default_purchase_price][0]" class="form-control" value="0.00">
                                    <input type="hidden" name="variation[default_sell_price][0]" class="form-control" value="0.00">
                                </td>
                                @foreach ($variations as $item)
                                <td>
                                    <select data-placeholder="Variation Value" name="variation[variation_value_id][0][{{$loop->index}}]" id="raw_status" required class="form-control">
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
                             {{--    <td>
                                    <input type="text" name="variation[default_purchase_price][0]" class="form-control" value="0.00">
                                </td>
                                <td>
                                    <input type="text" name="variation[default_sell_price][0]" class="form-control" value="0.00">
                                </td> --}}
                                <td>
                                    <button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fac-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

                <div class="form-group col-md-12 pt-3" align="right">
                    <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                            class="icon-arrow-right14 position-right"></i></button>
                    <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                        <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                </div>

        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('js/production/product.js') }}"></script>
<script src="{{ asset('js/production/add_product.js') }}"></script>
<script>
    $('.select_custom').select2({
        width: '88%'
    });

</script>
@endpush
