@extends('layouts.app', ['title' => _lang('Work Order Product Materials'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('WOP Materials Create')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('wop-materials-create') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-wop-materials.store')}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Add Work Order Product Materials')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Select Parent Catagory --}}
                <div class="col-md-6 mx-auto">
                    <label for="catagory_id">{{_lang('Select Work Order')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Work Order" name="wo_id"
                            id="catagory_id" data-url='{{route('admin.wop-materials.product')}}'
                            class="form-control select">
                            <option value="">Select Work Order</option>
                            @foreach ($models as $item)
                            <option value="{{$item->id}}">{{$item->prefix}}-{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" id="data">
        </div>

        <div class="form-group col-md-12" id="submit_btn" align="right" style="display:none">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('js/production/wop-materials.js') }}"></script>

@endpush
