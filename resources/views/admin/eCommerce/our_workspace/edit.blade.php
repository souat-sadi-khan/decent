@extends('layouts.app', ['title' => _lang('Production Work Order edit'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Work Order for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Production work order edit')}}</h1>
        <p>{{_lang('edit work order for Production.')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{Breadcrumbs::render('work-order-edit') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.eCommerce.our-workspace.update', $model->id)}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Edit Production work order')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Image One --}}
                <div class="form-control col-sm-6">
                    <div class="row">
                        <img style="height:200px; width:350px; padding:20px" id="current_image"
                            src="{{asset('storage/eCommerce/about/'.$model->image_one)}}" alt=""
                            class="img-fluid rounded">
                            <div id="blah_one"></div>
                        <div class="col-md-6 form-group">
                            <label for="image_one">{{_lang('Image One (545x545)')}}</label>
                            <input type="file" name="image_one" id="image_one" class="form-control" />
                        </div>

                        {{-- Image One alt --}}
                        <div class="col-md-6 form-group">
                            <label for="image_one_alt">{{_lang('Image One Alt')}}</label>
                            <input type="text" value="{{$model->image_one_alt}}" name="image_one_alt" id="image_one_alt"  class="form-control" />
                        </div>
                    </div>
                </div>

                {{-- Image Two --}}
                <div class="form-control col-sm-6">
                    <div class="row">
                        <img style="height:200px; width:350px; padding:20px" id="current_image_two"
                            src="{{asset('storage/eCommerce/about/'.$model->image_two)}}" alt=""
                            class="img-fluid rounded">
                            <div id="blah_two"></div>
                        <div class="col-md-6 form-group">
                            <label for="image_two">{{_lang('Image Two (245x310) ')}}</label>
                            <input type="file" name="image_two" id="image_two" class="form-control" />
                        </div>
                        {{-- Image Two Alt --}}
                        <div class="col-md-6 form-group">
                            <label for="image_two_alt">{{_lang('Image Two Alt')}}</label>
                            <input type="text"  value="{{$model->image_two_alt}}" name="image_two_alt" id="image_two_alt" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-control col-sm-6">
                    <div class="row">
                        <img style="height:200px; width:350px; padding:20px" id="current_image_three"
                            src="{{asset('storage/eCommerce/about/'.$model->image_three)}}" alt=""
                            class="img-fluid rounded">
                            <div id="blah_three"></div>
                        {{-- Image Three --}}
                        <div class="col-md-6 form-group">
                            <label for="image_three">{{_lang('Image Three (385x310)')}}</label>
                            <input type="file" name="image_three" id="image_three" class="form-control" />
                        </div>

                        {{-- Image Three Alt--}}
                        <div class="col-md-6 form-group">
                            <label for="image_three_alt">{{_lang('Image Three Alt')}}</label>
                            <input type="text" value="{{$model->image_three_alt}}" name="image_three_alt" id="image_three_alt"
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-control col-sm-6">
                    <div class="row">
                        <img style="height:200px; width:350px; padding:20px" id="current_image_four"
                            src="{{asset('storage/eCommerce/about/'.$model->image_four)}}" alt=""
                            class="img-fluid rounded">
                            <div id="blah_four"></div>
                        {{-- Image Four --}}
                        <div class="col-md-6 form-group">
                            <label for="image_four">{{_lang('Image Four( 640x220 )')}}</label>
                            <input type="file" name="image_four" id="image_four" class="form-control" />
                        </div>

                        {{-- Image Four alt --}}
                        <div class="col-md-6 form-group">
                            <label for="image_four_alt">{{_lang('Image Four Alt')}}</label>
                            <input type="text" value="{{$model->image_four_alt}}" name="image_four_alt" id="image_four_alt" class="form-control" />
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Update')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}
                <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>
</form>

<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script src="{{ asset('js/production/work_order.js') }}"></script>
<script>

$("#image_one").on('change', function () {
    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#blah_one");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "mx-auto img-fluid rounded",
                "style":"height:200px; width:350px; padding:20px; margin:0px auto"
            }).appendTo(image_holder);

        }
        $("#current_image").hide('slow');
        image_holder.show('slow');
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});

$("#image_two").on('change', function () {
    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#blah_two");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "mx-auto img-fluid rounded",
                "style":"height:200px; width:350px; padding:20px; margin:0px auto"
            }).appendTo(image_holder);

        }
        $("#current_image_two").hide('slow');
        image_holder.show('slow');
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});

$("#image_three").on('change', function () {
    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#blah_three");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "mx-auto img-fluid rounded",
                "style":"height:200px; width:350px; padding:20px; margin:0px auto"
            }).appendTo(image_holder);

        }
        $("#current_image_three").hide('slow');
        image_holder.show('slow');
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});


$("#image_four").on('change', function () {
    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#blah_four");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "mx-auto img-fluid rounded",
                "style":"height:200px; width:350px; padding:20px; margin:0px auto"
            }).appendTo(image_holder);

        }
        $("#current_image_four").hide('slow');
        image_holder.show('slow');
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});
</script>
@endpush
