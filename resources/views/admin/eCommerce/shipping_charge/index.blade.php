@extends('layouts.app', ['title' => _lang('Shipping Charge'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="shipping charge"><i class="fa fa-universal-access mr-4"></i> {{_lang('shipping charge')}}</h1>
            <p>{{_lang('Create shipping charge for product. Here you can Add, Edit & Delete the shipping charge')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('shipping-charge') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @can('ecommerce_shiping_charge.create')
                    <h3 class="tile-title">
                        <button data-placement="bottom" title="Create New shipping charge" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.eCommerce.shipping-charge.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    </h3>
                @endcan 
                
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.shipping-charge.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Shipping Area')}}</th>
                                <th>{{_lang('Shipping Charge')}}</th>
                                <th>{{_lang('Note')}}</th>
                                <th width="15%">{{_lang('Action')}}</th>
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
    <script src="{{ asset('js/eCommerce/shipping_charge.js') }}"></script>
@endpush

