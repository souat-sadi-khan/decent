@extends('layouts.app', ['title' => _lang('Special Offer'), 'modal' => 'xl'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Product Coupons"><i class="fa fa-universal-access mr-4"></i> {{_lang('Special Offer Product')}}</h1>
            <p>{{_lang('Here You Can see all of your Special Offer list. you can add or remove product from your Hot Sale product list')}}</p>
        </div>
        {{-- <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('slider') }}
        </ul> --}}
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('ecommerce_special_offer.create')
                    <h3 class="tile-title">
                        <button data-placement="bottom" title="Create New Special Offer" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.eCommerce.special-offer.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    </h3>
                @endcan 
            
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.special-offer.datatable') }}">
                        <thead>
                            <tr>
                                <th width="5%">{{_lang('id')}}</th>
                                <th width="25%">{{_lang('Photo')}}</th>
                                <th width="20%">{{_lang('Name')}}</th>
                                <th width="2%">{{_lang('Product')}}</th>
                                <th width="30%">{{_lang('Action')}}</th>
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
    <script src="{{ asset('js/eCommerce/special_offer.js') }}"></script>

    
@endpush

