@extends('layouts.app', ['title' => _lang('Employee Attendance List'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Employee Attendance List."><i class="fa fa-universal-access mr-4"></i> {{_lang('Employee Attendance List')}}</h1>
            <p>{{_lang('Create Employee Attendance List.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('employee-attendance') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="card">
    <div class="card-header row">
        <div class="col-md-6" style="float:left;">
            <h6>{{_lang('Employee Attendance List')}}</h6>
        </div>

        <div class="col-md-6" style="float:right;">
            <h3 class="tile-title">
                @can('employee_attendance.create')
                <a data-placement="bottom" title="Create New Employee Attendance" type="button" class="btn btn-info" href="{{ route('admin.attendance-employee-attendance.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</a>
                @endcan
            </h3>
        </div>
    </div>
    <div class="card-body">
            <div class="row">

            {{-- Filter Employee --}}

            {{-- Employee Category --}}
            <div class="col-md-3 form-group">
                <label for="name">{{_lang('Employee Category')}} </label>
                <select name="category[]" class="form-control select" multiple id="category" data-placeholder="Select Employee Option" >
                    <option value="">Select Option</option>
                        @foreach ($categorys as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                </select>
            </div>

            {{-- Department --}}
            <div class="col-md-3 form-group">
                <label for="name">{{_lang('Department')}} </label>
                <select name="department[]" class="form-control select" multiple id="department" data-placeholder="Select Department">
                    <option value="">Select Department</option>
                        @foreach ($departments as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                </select>
            </div>

            {{-- Designation --}}
            <div class="col-md-3 form-group">
                <label for="name">{{_lang('Designation')}} </label>
                <select name="designation[]" class="form-control select" multiple id="designation" data-placeholder="Select Designation">
                    <option value="">Select Designation</option>
                        @foreach ($designations as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                </select>
            </div>

            {{-- Month --}}
            <div class="col-md-3 form-group">
                    <label for="month">{{_lang('Month')}} <span class="text-danger">*</span>
                    </label>
                <input type="text" autocomplete="off" value="{{$today->year}}-{{$today->month}}" name="month" id="month" class="form-control month" placeholder="Month" required>
            </div>
            <div class="col-12">
                <div class="table-responsive p-2" id="data">
                </div>
            </div>

            @can('employee_attendance.create')
                <div class="form-group col-md-12" align="right">
                    {{-- <input type="hidden" name="type[]" value=" "> --}}
                    <button type="button" class="btn btn-primary" id="submit">{{_lang('Filter')}}<i
                            class="icon-arrow-right14 position-right"></i></button>
                </div>
            @endcan
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
    <script src="{{ asset('js/employee/attendance.js') }}"></script>

    <script>
         $(document).on('click', '#submit', function() {
        var category = $('#category').val();
        var department = $('#department').val();
        var designation = $('#designation').val();
        var month = $('#month').val();
        $.ajax({
            url: '{{route("admin.attendance-attendance.fetch")}}',
            type: 'POST', 
            data: { category:category,month:month,department: department,designation: designation},
            dataType:'html',
            success: function (data) {
                console.log(data);
                
                $('#data').html(data);
                 _componentSelect2Normal();
            }
        });
    });

    $('.month').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });
    </script>
@endpush