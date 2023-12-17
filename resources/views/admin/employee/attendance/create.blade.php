@extends('layouts.app', ['title' => _lang('Employee Attendance'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Employee Attendance."><i class="fa fa-universal-access mr-4"></i> {{_lang('Employee Attendance')}}</h1>
            <p>{{_lang('Create Employee Attendance.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('employee-attendance-create') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="card">
    <div class="card-header row">
        <div class="col-md-6">
            <h6>{{_lang('Create New Employee Attendance')}}</h6>
        </div>
        <div class="form-group col-md-6" align="right">
            <h3 class="tile-title">
                    @can('employee_attendance.show')
                    <a data-placement="bottom" title="Employee Attendance List" type="button" class="btn btn-info" href="{{ route('admin.attendance-employee-attendance.index') }}"><i class="fa fa-bars mr-2" aria-hidden="true"></i></i>{{_lang('Attendance List')}}</a>
                    @endcan
                </h3>
        </div>
    </div>


    <div class="card-body">
        <form action="{{route('admin.attendance-employee-attendance.store')}}" method="post" id="content_form">
            @csrf
            <div class="row">

            {{-- Filter Employee --}}

            {{-- Department --}}
            <div class="col-md-4 form-group">
                <label for="name">{{_lang('Department')}} </label>
                <select name="department[]" class="form-control select" multiple id="department" data-placeholder="Select Department" data-url="{{ route('admin.attendance-attendance.department') }}">
                    <option value="">Select Department</option>
                        @foreach ($departments as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                </select>
            </div>

            {{-- Designation --}}
            <div class="col-md-4 form-group">
                <label for="name">{{_lang('Designation')}} </label>
                <select name="designation[]" class="form-control select" multiple id="designation" data-placeholder="Select Designation" data-url="{{ route('admin.attendance-attendance.designation') }}">
                    <option value="">Select Designation</option>
                        @foreach ($designations as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                </select>
            </div>

            {{-- Date of Attendance --}}
            <div class="col-md-4 form-group">
                <label for="date">{{_lang('Date of Attendance')}} <span class="text-danger">*</span></label>
                <input type="text" value="{{now()}}" autocomplete="off" data-url="{{ route('admin.attendance-attendance.date') }}" name="date" id="date" class="form-control date" placeholder="Date of Attendance" required>
            </div>

            <div class="col-md-12" id="data_item"></div>
                <div class="col-12">
                    <div class="table-responsive p-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="30%">
                                        Name
                                    </th>
                                    <th width="30%">
                                        <select class="custom-select" id="change">
                                            <option value="null">Select One</option>
                                            @foreach ($types as $item)
                                                <option value="{{$item->id}}">{{$item->name}} ({{$item->alias}})</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th width="40%"></th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>
                                        <input type="hidden" name="employee[]" value="{{$employee->id}}">
                                        {{$employee->name}} ({{$employee->prefix.numer_padding($employee->code, get_option('digits_employee_code'))}}) <br>
                                        <span class="font-80pc">{{current_designation($employee->id)?current_designation($employee->id):""}}
                                            ({{designation_category($employee->id)}})</span>
                                    </td>
                                    <td>
                                        <select class="custom-select col-12 form-control select select_value" name="type[]" id="type"  data-placeholder="Select Attendance Type">
                                            <option value="">Select One</option>
                                            @foreach ($types as $item)
                                                <option value="{{$item->id}}">{{$item->name}} ({{$item->alias}})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <textarea rows="1" placeholder="Remarks" name="remarks[]" class="form-control" ></textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @can('employee_attendance.create')
                <div class="form-group col-md-12" align="right">
                    {{-- <input type="hidden" name="type[]" value=" "> --}}
                    <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                            class="icon-arrow-right14 position-right"></i></button>
                    <button type="button" class="btn btn-link" id="submiting"
                        style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}"
                            width="80px"></button>
                </div>
                @endcan
            </div>
        </form>
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
     $(document).on('change', '#department', function() {
        var department = $(this).val();
        var designation = $('#designation').val();
        var url = $(this).data('url'); 
        $.ajax({
            url: url,
            type: 'POST', 
            data: { department: department,designation: designation},
            success: function (data) {
                $('#data').html(data);
                 _componentSelect2Normal();

            }
        });
    });


    $(document).on('change', '#designation', function() {
        var designation = $(this).val();
        var department = $('#department').val();
        var url = $(this).data('url'); 
        $.ajax({
            url: url,
            type: 'POST', 
            data: { department: department,designation: designation},
            success: function (data) {
                $('#data').html(data);
                 _componentSelect2Normal();
            }
        });
    });

    $(document).on('change', '#date', function() {
        var date = $(this).val();
        var designation = $('#designation').val();
        var department = $('#department').val();
        var url = $(this).data('url'); 
        $.ajax({
            url: url,
            type: 'POST', 
            data: { date:date,department: department,designation: designation},
            success: function (data) {
                $('#data').html(data);
                 _componentSelect2Normal();
            }
        });
        $.ajax({
            url: '/admin/date_check_for_holiday',
            type: 'POST', 
            data: { date:date },
            success: function (data) {
                $('#data_item').html(data);
            }
        });

    });

     $(document).on('change', '#change', function() {
         var id = $(this).val();
         $(".select_value").each(function(i, ){
            $(this).val(id).trigger('change');
        });
    });

</script>
@endpush