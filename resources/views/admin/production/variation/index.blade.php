@extends('layouts.app', ['title' => _lang('Production Variation Template'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Production Variation Template."><i class="fa fa-stumbleupon mr-4"></i> {{_lang('Production Variation Template')}}</h1>
            <p>{{_lang('Create Production Variation Template. Here you can add variation like - size, color etc.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('production-variation') }}
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
                    @php
                        $query = App\models\Production\VariationTemplate::count();
                    @endphp
                    @if ($query != 2)
                        @can('production_variation.create')
                            <button data-placement="bottom" title="Create New Production Variation Template" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.production-variation.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                        @endcan
                    @endif
                </h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.production-variation.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Variation Name')}}</th>
                                <th>{{_lang('Variation Template')}}</th>
                                <th>{{_lang('Status')}}</th>
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
    <script src="{{ asset('js/production/variation.js') }}"></script>
@endpush

