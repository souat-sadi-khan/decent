@extends('layouts.app', ['title' => _lang('Production Product Show'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Production Product Show')}}</h1>
        <p>{{_lang('Show Product for Production.')}}</p>
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
<div class="card-header">
    <h6>{{_lang('Raw Material Details')}}</h6>
</div>
<div class="card py-4">
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('SL') }}</th>
                    <th>{{ _lang('Raw Material') }}</th>
                    <th>{{ _lang('Quantity') }}</th>
                    {{--  <th>{{ _lang('Price') }}</th>
                    <th>{{ _lang('Total Price') }}</th>
                    <th>{{ _lang('Waste') }}</th>
                    <th>{{ _lang('Uses') }}</th> --}}
                    <th>{{ _lang('Description') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->material as $item)
                <tr>
                    <td>{{ $loop->index+1 }} </td>
                    <td>{{ $item->material->name }} </td>
                    <td> {{ $item->qty }} <small>{{ $item->unit ? $item->unit->unit : ''}} </small> </td>
                    {{--      <td> {{ $item->unit_price }} </td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->waste }}</td>
                    <td>{{ $item->uses }}</td> --}}
                    <td>{!! $item->description !!} </td>
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