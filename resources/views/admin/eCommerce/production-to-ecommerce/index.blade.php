@extends('layouts.app', ['title' => _lang('Ecommerce Stock '), 'modal' => 'lg'])
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Work Order for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Production to eCommerce')}}</h1>
            <p>{{_lang('Create New ecommerce product from Production. Here you can Add, Edit & Delete The production Work Order')}}</p>
        </div>
    </div>
@stop

@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">
                    <a data-placement="bottom" title="Create New Ecommerce Product" type="button" class="btn btn-info" href ="{{ route('admin.eCommerce.production-to-ecommerce.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('Transfer Stock')}}</a>
                    
                    <a data-placement="bottom" title="" type="button" class="btn float-right btn-info" href ="{{ route('admin.eCommerce.production-to-ecommerce.reverse') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('Exchange')}}</a>

                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.producion-to-ecommerce.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Product')}}</th>
                                <th>{{_lang('Variation')}}</th>
                                <th>{{_lang('Quantity')}}</th>
                                <th>{{_lang('Price')}}</th>
                                <th>{{_lang('Date')}}</th>
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
    <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script src="{{ asset('js/eCommerce/production-to-ecommerce.js') }}"></script>
@endpush