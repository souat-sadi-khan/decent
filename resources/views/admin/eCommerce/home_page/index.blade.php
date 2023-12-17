@extends('layouts.app', ['title' => _lang('Home Page'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Home page"><i class="fa fa-universal-access mr-4"></i> {{_lang('Home Page')}}</h1>
            <p>{{_lang('Here you can Add, Edit & Delete home page image')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('eCommerce.home-page') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">
                        <a data-placement="bottom" title="Create New home page image" type="button" class="btn btn-info" href ="{{ route('admin.eCommerce.home-page.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</a>
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.home-page.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Product Name')}}</th>
                                <th>{{_lang('Banner Image One')}}</th>
                                <th>{{_lang('BannerImage Two')}}</th>
                                <th>{{_lang('Banner Frame One')}}</th>
                                <th>{{_lang('Banner Frame Two')}}</th>
                                <th>{{_lang('Slider Image')}}</th>
                                <th>{{_lang('Category Image')}}</th>
                                <th>{{_lang('action')}}</th>
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
    <script src="{{ asset('js/eCommerce/home.js') }}"></script>
@endpush

