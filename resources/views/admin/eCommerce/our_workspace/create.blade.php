@extends('layouts.app', ['title' => _lang('Our workspace'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Our workspace"><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Our workspace')}}</h1>
        <p>{{_lang('Create Our workspace')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{Breadcrumbs::render('our-workspace-create') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.eCommerce.our-workspace.store')}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Add New Team')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Image One --}}
                <div class="col-md-3 form-group">
                    <label for="image_one">{{_lang('Image One (545x545)')}}</label>
                    <input type="file" required  name="image_one" id="image_one" required class="form-control" />
                </div>

                {{-- Image One alt --}}
                <div class="col-md-3 form-group">
                    <label for="image_one_alt">{{_lang('Image One Alt')}}</label>
                    <input type="text"  name="image_one_alt" id="image_one_alt" required class="form-control" />
                </div>

                {{-- Image Two --}}
                <div class="col-md-3 form-group">
                    <label for="image_two">{{_lang('Image Two (245x310) ')}}</label>
                    <input type="file"  name="image_two" id="image_two" required class="form-control" />
                </div>
                 {{-- Image Two Alt --}}
                <div class="col-md-3 form-group">
                    <label for="image_two_alt">{{_lang('Image Two Alt')}}</label>
                    <input type="text"  name="image_two_alt" id="image_two_alt" required class="form-control" />
                </div>

                {{-- Image Three --}}
                <div class="col-md-3 form-group">
                    <label for="image_three">{{_lang('Image Three (385x310)')}}</label>
                    <input type="file"  name="image_three" id="image_three" required class="form-control" />
                </div>

                {{-- Image Three Alt--}}
                <div class="col-md-3 form-group">
                    <label for="image_three_alt">{{_lang('Image Three Alt')}}</label>
                    <input type="text"  name="image_three_alt" id="image_three_alt" required class="form-control" />
                </div>

                {{-- Image Four --}}
                <div class="col-md-3 form-group">
                    <label for="image_four">{{_lang('Image Four( 640x220 )')}}</label>
                    <input type="file"  name="image_four" id="image_four" required class="form-control" />
                </div>

                {{-- Image Four alt --}}
                <div class="col-md-3 form-group">
                    <label for="image_four_alt">{{_lang('Image Four Alt')}}</label>
                    <input type="text"  name="image_four_alt" id="image_four_alt" required class="form-control" />
                </div>

            </div>
        </div>

        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting"
                style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>
</form>
<div class="modal fade border-top-success rounded-top-0 brand_modal" role="dialog" >
</div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script>
    _modalFormValidation();
</script>
@endpush
