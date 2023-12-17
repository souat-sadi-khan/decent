@extends('layouts.app', ['title' => _lang('language'), 'modal' => 'lg'])

{{-- Header section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Create Your New Language From Here."><i class="fa fa-language mr-4"></i> {{_lang('language')}}</h1>
            <p>{{_lang('Here, you can add a new language. You can Edit, Delete This Language File from here')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('language') }}
        </ul>
    </div>
@stop

{{-- Main section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            @can('language.create')
                <h3 class="tile-title">
                    <button data-placement="bottom" title="Create New Language" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.language.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                </h3>
            @endcan
            <div class="tile-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th>{{_lang('language')}}</th>
                            <th>{{_lang('edit_tarnslation')}}</th>
                            <th>{{_lang('remove')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(get_language_list() as $language)
                            <tr>
                                <td>{{ ucwords($language) }}</td>
                                <td>
                                    @can('language.update')
                                    <a data-placement="bottom" title="Translate {{$language}} Language" href="{{ route('admin.language.edit',$language) }}" class="btn btn-info"><i class="icon-pencil7"></i>{{_lang('translate')}}</a>
                                    @endcan
                                </td>
                                <td>
                                    @can('language.delete')
                                    <a href="" data-placement="bottom" title="Delete {{$language}} Language For Forever" class="btn btn-danger" id="delete_item" data-id ="{{$language}}" data-url="{{route('admin.language.delete',$language) }}">{{_lang('trash')}}</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
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
    <script src="{{ asset('js/pages/setting.js') }}"></script>
@endpush

