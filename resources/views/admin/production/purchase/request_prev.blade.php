@extends('layouts.app', ['title' => _lang('Purchase Request'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Purchase Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Purchase Request')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-header">
        <h6>{{_lang('Send Purchase Type ')}}</h6>
    </div>
    <div class="card-body">
          @include('admin.utilities.include_request',['row'=>route('admin.production-purchase.create',['type'=>'row_material']),'work'=>route('admin.production-purchase.create',['type'=>'work_order'])])
    </div>
    <!-- /basic initialization -->
    @stop
    {{-- Script Section --}}
    @push('scripts')
    @endpush