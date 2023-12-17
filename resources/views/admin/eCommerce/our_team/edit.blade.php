@extends('layouts.app', ['title' => _lang('Our Team edit'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Our Team."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Our Team edit')}}</h1>
        <p>{{_lang('edit work order for our team.')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{Breadcrumbs::render('our-team-edit') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.eCommerce.our-team.update', $model->id)}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Update Our Team')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Team Name --}}
                <div class="col-md-6 form-group">
                    <label for="team_name">{{_lang('Team Name')}}</label>
                    <input type="text"  name="team_name" id="team_name" value="{{$model->team_name}}" required class="form-control" />
                </div>

                {{-- Team Designation --}}
                <div class="col-md-6 form-group">
                    <label for="team_designation">{{_lang('Team Designation')}}</label>
                    <input type="text"  name="team_designation" value="{{$model->team_designation}}" id="team_designation" required class="form-control" />
                </div>

                
                {{-- Image One --}}
                <div class="col-md-3 form-group">
                     <label for="image_one">{{_lang('Image One ( 280x290 )')}}</label>
                    <input type="file"  name="image_one" id="image_one" class="form-control" />
                </div>

                <div class="col-md-3 form-group">
                    <label for="image_one_alt">{{_lang('Image One Alt')}}</label>
                    <input type="text"  name="image_one_alt" value="{{$model->image_one_alt}}" id="image_one_alt" class="form-control" />
                </div>

                {{-- Image Two --}}
                <div class="col-md-3 form-group">
                    <label for="image_two">{{_lang('Image Two (1920x320)')}}</label>
                    <input type="file"  name="image_two" id="image_two" class="form-control" />
                </div>

                <div class="col-md-3 form-group">
                    <label for="image_two_alt">{{_lang('Image Two Alt')}}</label>
                    <input type="text"  name="image_two_alt" value="{{$model->image_two_alt}}" id="image_two_alt" class="form-control" />
                </div>

                {{-- Team Description --}}
                <div class="col-md-12 form-group">
                    <label for="description">{{_lang('Description')}}</label>
                    <textarea name="description" class="form-control" id="summernote" placeholder="Enter description">{{$model->description}}</textarea>
                </div>

            </div>
        </div>

        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Submit')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting"
                style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script src="{{ asset('js/eCommerce/our_team.js') }}"></script>
<script>
$(document).ready(function() {
       $('#summernote').summernote({
           height: 300
       });
   });
</script>
@endpush