@extends('layouts.app', ['title' => _lang('Production Product Edit'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Production Product Edit')}}</h1>
        <p>{{_lang('Edit Product for Production.')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('product-edit') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-product.update', $product->id)}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Edit Production Product')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="prefix">{{_lang('Code')}} <span class="text-danger">*</span>
                    </label>
                    <div class="row">
                        <div class="col-md-4"><input type="text" readonly name="prefix" id="prefix" class="form-control"
                                placeholder="Prefix" value="{{$product->prefix}}" required></div>
                        <div class="col-md-8"> <input type="text" readonly name="code" id="code" class="form-control"
                                placeholder="Code Here" required value="{{$product->code}}"></div>
                    </div>
                </div>

                {{-- Articel --}}
                <div class="col-md-3 form-group">
                    <label for="articel">{{_lang('Articel')}} </label>
                    <input type="text" name="articel" value="{{$product->code}}" id="articel" class="form-control"
                        placeholder="Enter Articel">
                </div>

                {{-- Name --}}
                <div class="col-md-5 form-group">
                    <label for="name">{{_lang('Name')}} <span class="text-danger">*</span>
                    </label>
                    <input type="text" value="{{$product->name}}" name="name" id="name" class="form-control"
                        placeholder="Enter Name" required>
                </div>

                {{-- Select Parent Catagory --}}
                <div class="col-md-4 form-group">
                    <label for="catagory_id">{{_lang('Select Parent Category')}} <span class="text-danger">*</span>
                    </label>
                    <select required data-placeholder="Select Parent Catagory" name="catagory_id" id="catagory_id"
                        data-url='{{route('admin.production-product.category')}}' class="form-control select">
                        <option value="">Select Parent Catagory</option>
                        @foreach ($categorys as $item)
                        <option {{$product->category_id == $item->id?'selected':''}} value="{{$item->id}}">
                            {{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Select Sub Catagory --}}
                <div class="col-md-4 form-group">
                    <label for="sub_category">{{_lang('Select Sub Category')}} <span class="text-danger">*</span>
                    </label>
                    <select data-placeholder="Select Parent Catagory" name="sub_category" id="sub_category"
                        class="form-control select">
                        <option value="{{$product->sub_category_id}}">{{$product->sub_category?$product->sub_category->name:''}}</option>
                    </select>
                </div>

                {{-- Select status --}}
                <div class="col-md-4 form-group">
                    <label for="status">{{_lang('Product Status')}}
                    </label>
                    {{-- <select data-placeholder="Select Product Status" name="status" id="status"
                        class="form-control select">
                        <option {{$product->category_id == 'Active'?'selected':''}} value="Active">Active</option>
                        <option {{$product->category_id == 'InActive'?'selected':''}} value="InActive">InActive</option>
                    </select> --}}
                      <input type="text" class="form-control" name="status" value="Sample" readonly>
                </div>



                {{-- Product Details --}}
                <div class="col-md-6 form-group">
                    <label for="description">{{_lang('Description')}}
                    </label>
                    <textarea name="description" class="form-control summernote" id="description"
                        placeholder="Enter Product Details">{!! $product->description !!}</textarea>
                </div>

                {{-- Select Image --}}
                <div class="col-md-6 form-group">
                    <label for="photo">{{_lang('Upload Product Photo')}}</label>
                    <input type="file" name="photo" id="photo" class="dropify"
                        data-default-file="{{isset($product)?asset('storage/product/'.$product->photo):''}}" />
                    <input type="hidden" name="old_photo" value="{{$product->photo}}">
                </div>

            </div>
        </div>

        <div class="card-header">
            <h6>{{_lang(' Product Raw Material')}}</h6>
        </div>


        <div class="card-body">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="status">{{_lang('Select Raw Material')}}
                        </label>
                        <select data-placeholder="Select Raw Material" id="raw_material"
                            data-url='{{route('admin.production-product.category')}}' class="form-control select">
                            <option value="">Select Raw Material</option>
                            @foreach ($models as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="quantity">{{_lang('Quantity')}}</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input_number" name="quantity" id="quantity">
                            <input type="hidden" class="form-control" id="unit_id">
                            <div class="input-group-append">
                                <span class="input-group-text" id="unit">.00</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 form-group" id="unit_price_row">
                        {{-- <label for="unitPrice">{{_lang('Unit Price')}}</label> --}}
                        <input type="hidden" min="1" class="form-control" placeholder="Unit Price" maxlength="50"
                            id="unitPrice">
                    </div>

                    <div class="col-md-4 form-group" id="child_unit_row">
                       {{--  <label for="child_unit_price">{{_lang('Child unit price')}}</label> --}}
                        <div class="input-group mb-3">
                            <input type="hidden" class="form-control" id="child_unit_price">
                          {{--   <div class="input-group-append">
                                <span class="input-group-text" id="child_unit">{{ _lang('Unit') }}</span>
                            </div> --}}
                        </div>

                    </div>
                    <div class="col-md-4" id="unit_row">
                      {{--   <label for="grossPrice">{{_lang('Gross Price')}}</label>
                        <div class="input-group mb-3"> --}}
                            <input type="hidden" class="form-control" id="grossPrice" readonly>
                           {{--  <div class="input-group-append">
                                <span class="input-group-text">USD</span>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-md-4">
                       {{--  <label for="waste">{{_lang('Waste')}}</label> --}}
                        <div class="input-group mb-3">
                            <input type="hidden" class="form-control" maxlength="2" value="0" id="waste">
                         {{--    <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- <label for="uses">{{_lang('Uses')}}</label> --}}
                        <div class="input-group mb-3">
                            <input type="hidden" class="form-control" id="uses" readonly>
                           {{--  <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                       {{--  <label for="raw_status">{{_lang('Raw Material Status')}}
                        </label>
                        <select data-placeholder="Raw Material Status" name="raw_status" id="raw_status"
                            class="form-control  select">
                            <option selected value="Active">{{_lang('Active')}}</option>
                            <option value="InActive">{{_lang('InActive')}}</option>
                        </select> --}}
                        <input type="hidden" id="raw_status" name="raw_status" value="Active">
                    </div>

                    {{-- Product Details --}}
                    <div class="col-md-12 form-group">
                        <label for="raw_description">{{_lang('Description')}}
                        </label>
                        <textarea name="raw_description" class="form-control" id="raw_description"
                            placeholder="Enter Product Details"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-10">
                            <button type="button" class="btn btn-success" id="add"
                                data-url="{{ route('admin.production-product.product_add') }}">
                                {{ _lang('Add Raw Material For Product') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-20">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th>{{ _lang('Raw Material') }}</th>
                                <th>{{ _lang('Quantity') }}</th>
                            {{--     <th>{{ _lang('Price') }}</th>
                                <th>{{ _lang('Total Price') }}</th>
                                <th>{{ _lang('Waste') }}</th>
                                <th>{{ _lang('Uses') }}</th> --}}
                                <th><i class="fa fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody id="pursesDetailsRender">
                            @foreach ($product->material as $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="raw_material[]" value="{{ $item->material_id }}" class="form-control pid">
                                    {{ $item->material->name }}
                                </td>
                                <td>
                                <input type="text" class="qty form-control input_number qty_{{$item->id}}" id="{{$item->id}}" name="qty[]" value="{{ $item->qty }}" >
                                 <input type="hidden" class="form-control unit_price" id="unit_price_{{$item->id}}" data-id="{{$item->id}}" name="unit_price[]" value="{{ $item->unit_price }}">
                               <input type="hidden" name="raw_status[]" value="{{ $item->status }}">
                                <input type="hidden" name="raw_description[]" value="{{ $item->description }}">
                                 <input type="hidden" class="form-control price" id="price_{{$item->id}}" readonly name="price[]" value="{{ $item->price }}">
                                 <input type="hidden" class="form-control waste" maxlength="2" id="{{$item->id}}" name="waste[]" value="{{ $item->waste }}">
                                  <input type="hidden" name="unit[]" value="{{ $item->unit_id }}">
                                  <input type="hidden" readonly class="form-control uses" id="uses_{{$item->id}}" name="uses[]" value="{{ $item->uses }}">
                                </td>
                              {{--   <td>
                                <input type="text" class="form-control unit_price" id="unit_price_{{$item->id}}" data-id="{{$item->id}}" name="unit_price[]" value="{{ $item->unit_price }}">
                                </td> --}}
                              {{--   <td>
                                    <input type="hidden" name="raw_status[]" value="{{ $item->status }}">
                                    <input type="hidden" name="raw_description[]" value="{{ $item->description }}">
                                     <input type="text" class="form-control price" id="price_{{$item->id}}" readonly name="price[]" value="{{ $item->price }}">
                                </td> --}}
                              {{--   <td>
                                    <input type="number" class="form-control waste" maxlength="2" id="{{$item->id}}" name="waste[]" value="{{ $item->waste }}">
                                    <input type="hidden" name="unit[]" value="{{ $item->unit_id }}">
                                </td> --}}
                               {{--  <td>
                                    <input type="text" readonly class="form-control uses" id="uses_{{$item->id}}" name="uses[]" value="{{ $item->uses }}">
                                </td> --}}
                                <td>
                                    <button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Update')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>

<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script src="{{ asset('js/production/product.js') }}"></script>
<script src="{{ asset('js/production/add_product.js') }}"></script>
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
@endpush
