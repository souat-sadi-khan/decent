@extends('layouts.app', ['title' => _lang('Employee Details Information'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Employee Details Information for {{$model->name}} "><i
                class="fa fa-users mr-4"></i> {{_lang('Employee Details Information')}}</h1>
        <p>{{_lang('Here you can see')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('/employee-details', $model->uuid) }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<div class="tile">
    <div class="tile-body">
        <div class="row">
            <input type="hidden" id="model_id" value="{{$model->id}}">
            {{-- Edit Employee Information --}}
            <div class="col-md-8 p-3">
                <div class="accordion" id="accordionExample275">

                    @can('employee_list.access')
                        {{-- Basic Information Tab --}}
                        <div class="card z-depth-0 bordered">
                            <div style="cursor:pointer;" class="card-header according section" data-url="{{route('admin.ajax.basic_info', $model->id)}} " id="headingOne2" data-toggle="collapse"
                                data-target="#basic_info" aria-expanded="true" aria-controls="basic_info">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" >
                                        <i class="fa fa-graduation-cap mr-2"></i>Basic Information
                                    </button>
                                </h5>
                            </div>
                            <div id="basic_info" class="collapse" aria-labelledby="headingOne2" data-parent="#accordionExample275">
                                <div class="card-body">
                                    <div id="data1"></div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('employee_list.access')
                        {{-- Contact Information --}}
                        <div class="card z-depth-0 bordered">
                            <div style="cursor:pointer;" class="card-header collapsed section" id="headingTwo2" data-url="{{route('admin.ajax.contact_info', $model->id)}} "  data-toggle="collapse"
                                data-target="#contact_info" aria-expanded="false" aria-controls="contact_info">
                                <h5 class="mb-0">
                                    <button 
                                        class="btn btn-link " type="button" >
                                        <i class="fa fa-address-book fa-6 mr-2"> </i> Contact Information
                                    </button>
                                </h5>
                            </div>
                            <div id="contact_info" class="collapse" aria-labelledby="headingTwo2"
                                data-parent="#accordionExample275">
                                <div class="card-body">
                                    <div id="data1"></div>
                                </div>
                            </div>
                        </div>
                    @endcan 

                    {{-- Document Info --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;" data-url="{{route('admin.ajax.document_info')}}" data-toggle="collapse"
                            data-target="#document_info" aria-expanded="true" aria-controls="document_info"  class="card-header collapsed section" id="headingThree2">
                            <h5 class="mb-0">
                                <button  class="btn btn-link" type="button">
                                    <i class="fa fa-folder-open mr-2" aria-hidden="true"></i> Document Information
                                </button>
                            </h5>
                        </div>
                        <div id="document_info" class="collapse" aria-labelledby="headingThree2"
                            data-parent="#accordionExample275">
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>

                    <div style="position: absolute;top: 55%;left: 50%;z-index:100;  display: none;" id="loader_new">
                        <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i>
                    </div>

                    {{-- Qualification Information --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;" data-url="{{route('admin.ajax.qua_info')}}"  data-toggle="collapse"
                        data-target="#qua_info" aria-expanded="true" aria-controls="qua_info" class="card-header  collapsed section" id="headingFour2">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button">
                                    <i class="fa fa-book" aria-hidden="true"></i> Qualification Information
                                </button>
                            </h5>
                        </div>
                        <div id="qua_info" class="collapse" aria-labelledby="headingFour2"
                            data-parent="#accordionExample275">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                    {{-- Account Information --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;"  data-url="{{route('admin.ajax.account_info')}}"  data-toggle="collapse"
                        data-target="#account_info" aria-expanded="true" aria-controls="account_info" class="card-header  collapsed section" id="headingFive2" >
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button">
                                    <i class="fa fa-university mr-2" aria-hidden="true"></i> Account Information
                                </button>
                            </h5>
                        </div>
                        <div id="account_info" class="collapse" aria-labelledby="headingFive2"
                            data-parent="#accordionExample275">
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>

                    {{-- Login Information --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;"  data-url="{{route('admin.ajax.login_info')}}"  data-toggle="collapse"
                        data-target="#login_info" aria-expanded="true" aria-controls="login_info" class="card-header collapsed section" id="headingSix2" >
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button">
                                    <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i> Login Information
                                </button>
                            </h5>
                        </div>
                        <div id="login_info" class="collapse" aria-labelledby="headingSix2"
                            data-parent="#accordionExample275">
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>

                    {{-- Designation History --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;"  data-url="{{route('admin.ajax.desig_info')}}"  data-toggle="collapse"
                        data-target="#desig_info" aria-expanded="true" aria-controls="desig_info" class="card-header collapsed section" id="headingSeven2" >
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button">
                                    <i class="fa fa-user-plus mr-2" aria-hidden="true"></i> Designation History
                                </button>
                            </h5>
                        </div>
                        <div id="desig_info" class="collapse" aria-labelledby="headingSeven2"
                            data-parent="#accordionExample275">
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>

                    {{-- Term History --}}
                    <div class="card z-depth-0 bordered">
                        <div style="cursor:pointer;"  data-url="{{route('admin.term_info')}}"  data-toggle="collapse"
                        data-target="#term_info" aria-expanded="true" aria-controls="term_info" class="card-header collapsed section" id="headingTen2" >
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button">
                                    <i class="fa fa-user-times mr-2" aria-hidden="true"></i> Term History
                                </button>
                            </h5>
                        </div>
                        <div id="term_info" class="collapse" aria-labelledby="headingTen2"
                            data-parent="#accordionExample275">
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Employee Details Information --}}
            <div class="col-md-4 border border-success p-3">
                <div class="col-md-12 form-group">
                    <form action="{{route('admin.employee-list.Image_Upload',$model->id)}}" method="POST" id="imageUpload" enctype="multipart/form-data" >
                        <div class="form-group">
                            <label for="photo">{{_lang('Upload Your Photo')}}</label>
                            <input required type="file" name="photo" id="photo" class="dropify" data-default-file="{{isset($model) && $model->photo != null ?asset('storage/employee/'.$model->photo):''}}"/>
                        </div>
                        @if(isset($model) && isset($model->photo))
                            <input type="hidden" name="oldimage" value="{{$model->photo}}">
                        @endif
    
                        <div class="form-group col-md-12" align="center">
                            <input type="hidden" name="id" value="{{$model->id}}">
                            <button type="submit" class="btn btn-primary btn-sm"  id="submit_photo">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-success btn-sm " id="submiting_photo" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <h3 class="py-3">Personal Information</h3>
                    <table class="table table-sm custom-show-table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td class="text-right">{{$model->name}}</td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td class="text-right">{{$model->father_name}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-right">
                                    @php
                                        $id = $model->id;
                                        $term = App\models\employee\EmployeeTerm::where('employee_id',$id)->latest()->first();
                                        if($term AND $term->date_of_leaving) {
                                            echo '<span class="badge badge-danger">Inactive</span>'; 
                                        } else {    
                                            echo '<span class="badge badge-primary">Active</span>';
                                        }
                                    @endphp     
                                </td>
                            </tr>
                            <tr>
                                <td>Date of Joining</td>
                                <td class="text-right">
                                    @php
                                        $id = $model->id;
                                        $term = App\models\employee\EmployeeTerm::where('employee_id',$id)->latest()->first();
                                        echo carbonDate($term->date_of_joining);
                                    @endphp     
                                </td>
                            </tr>
                            <tr>
                                <td>Designation</td>
                                <td class="text-right"><span>
                                        @php
                                            $query = App\models\employee\EmployeeDesignation::where('employee_id',$model->id)->latest()->first();
                                            $designation_id = $query->designation_id;
                                            $designation = App\models\employee\Designation::where('id', $designation_id)->first();
                                            echo $designation->name;
                                        @endphp
                                    </span></td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td class="text-right">{{$model->mother_name}}</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td class="text-right">{{$model->contact_number}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td class="text-right">{{$model->gender}}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td class="text-right">{{carbonDate($model->date_of_birth)}}</td>
                            </tr>
                            <tr>
                                <td>Created at</td>
                                <td class="text-right">{{$model->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Last Updated at</td>
                                <td class="text-right">{{$model->updated_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script>
    $('.date').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true
    });
    $('.select').select2({
        width: '100%'
    });

    $(function () {
        $('.section').click(function () {
            var url = $(this).data("url");
            var did = $(this).data('target');
            var model_id = $('#model_id').val();
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    model_id: model_id
                },
                beforeSend: function() {
                    $('#loader_new').fadeIn();
                }, 
                success: function (data) {
                    $(did).html(data);
                    $('#loader_new').fadeOut();
                    _componentSelect2Normal();
                    _componentRemoteModalLoadAfterAjax();
                }
            });
        });
    })

</script>
<script>
    _componentDropFile();
    var _ImageUpload = function() {
    if ($('#imageUpload').length > 0) {
        $('#imageUpload').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#imageUpload').on('submit', function(e) {
        e.preventDefault();
        $('#submit_photo').hide();
        $('#submiting_photo').show();
        $(".ajax_error").remove();
        var submit_url = $('#imageUpload').attr('action');
        //Start Ajax
        var formData = new FormData($("#imageUpload")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);

                } else {
                    toastr.success(data.message);
                    $('#submit_photo').show();
                    $('#submiting_photo').hide();
                    $('#imageUpload')[0].reset();
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#imageUpload')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 2500);
                    }
                }
            },
            error: function(data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function(key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.warning(jsonValue.message);

                }
                _componentSelect2Normal();
                $('#submit_photo').show();
                $('#submiting_photo').hide();
            }
        });
    });
};

_ImageUpload();

  </script>
@endpush