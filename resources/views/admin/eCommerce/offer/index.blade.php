@extends('layouts.app', ['title' => _lang('Offer Product'), 'modal' => 'xl'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Product Coupons"><i class="fa fa-universal-access mr-4"></i> {{_lang('Offer Product')}}</h1>
            <p>{{_lang('Here You Can see all of your Hot Sale product list. you can add or remove product from your Offer product list')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('slider') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('ecommerce_offer.create')
                    <h3 class="tile-title">
                        <button data-placement="bottom" title="Create New Slider" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.eCommerce.eCommerce-offer.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    </h3>
                @endcan
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.eCommerce-offer.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Size')}}</th>
                                <th>{{_lang('Photo')}}</th>
                                <th>{{_lang('Old Price')}}</th>
                                <th>{{_lang('New Price')}}</th>
                                <th>{{_lang('Heading')}}</th>
                                <th>{{_lang('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script src="{{ asset('js/eCommerce/ecommerce_offer.js') }}"></script>
@endpush

