@extends('layouts.app', ['title' => _lang('Production Product Variation'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product Variation for Production."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Production Product Show')}}</h1>
        <p>{{_lang('Show Product Variation')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('product-view') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-header">
        <h6>{{_lang('Production Product Details')}}</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <img class="w-75 pl-4" src="{{isset($product)?asset('storage/product/'.$product->photo):''}}" alt="">
            </div>
            <div class="col-md-6">
                <div class="pr-3">
                    <p class="h4 pt-4">{{_lang('Name')}} : {{$product->name}}</p>
                    <p class="h5"> {{_lang('Code')}} : {{$product->prefix}}-{{$product->code}}</p>
                    <p> {{_lang('Articel')}} : {{$product->articel}}</p>
                    <p> {{_lang('Parent Category')}} : {{$product->category?$product->category->name:''}} </p>
                    <p> {{_lang('Sub Category')}} : {{$product->sub_category?$product->sub_category->name:''}}</p>
                    <p>{{_lang('Product Status')}} : <span
                        class="font-weight-bold badge {{$product->status == 'Active'?'badge-success':'badge-danger'}}">
                    {{$product->status}} </span> </p>
                    <p> {!!$product->description!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="card py-4">
    <div class="card-header">
        <h6>{{_lang('Product Variation Details')}}</h6>
    </div>
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('SL') }}</th>
                    <th>{{_lang('Name')}}</th>
                    <th>{{_lang('Sub Sku')}}</th>
                    <th>{{$product->product_variation->variation1->name}}</th>
                    <th>{{$product->product_variation->variation2->name}}</th>
                    @can('view_product.cost_price')
                    <th>
                        {{_lang('Purchase Price')}}
                    </th>
                    @endcan
                     @can('view_product.sale_price')
                    <th>
                        {{_lang('Sell Price')}}
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($product->product_variation->variation as $item)
                <tr>
                    <td>{{ $loop->index+1 }} </td>
                    <td>{{ $item->name }} </td>
                    <td> {{ $item->sub_sku }}</td>
                    <td> {{ $item->value1->name }}</td>
                    <td> {{ $item->value2->name }}</td>
                    @can('view_product.cost_price')
                    <td> {{ $item->default_purchase_price }}</td>
                    @endcan
                    @can('view_product.sale_price')
                    <td> {{ $item->default_sell_price }}</td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script src="{{ asset('js/production/product.js') }}"></script>
<script src="{{ asset('js/production/add_product.js') }}"></script>
@endpush