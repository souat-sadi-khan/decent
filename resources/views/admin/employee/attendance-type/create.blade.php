<div class="card">
    <div class="card-header">
        <h6>{{_lang('Create New Employee Attendance Type')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.attendance-attendance-type.store')}}" method="post" id="content_form">
            @csrf
            <div class="row">
                {{-- Employee Attendance Type Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Attendance Type Name')}} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="Enter Employee Attendance Type Name" required>
                </div>
                {{-- Employee Attendance Type Alias --}}
                <div class="col-md-6 form-group">
                    <label for="alias">{{_lang('Attendance Type Alias')}}
                    </label>
                    <input type="text" name="alias" id="alias" class="form-control"
                        placeholder="Enter Employee Attendance Type Alias" required>
                </div>
        
                {{-- Employee Attendance Type --}}
                <div class="col-md-6 form-group">
                    <label for="type">{{_lang('Employee Attendance Type')}} <span class="text-danger">*</span> </label>
                    <select data-parsley-errors-container="#sata_parsley_error_employee_attendance_type_for_createing_attendance_type" required name="type" id="type" class="form-control select" data-placeholder="Select Attendance Type">
                        <option value="">{{_lang('Select Attendance Type')}}</option>
                        <option value="Present">{{_lang('Present')}}</option>
                        <option value="Holiday">{{_lang('Holiday')}}</option>
                        <option value="On_leave">{{_lang('On Leave Without pay - Absent')}}</option>
                        <option value="Present_half_pay">{{_lang('Present with half day pay')}}</option>
                        <option value="production_based_earning">{{_lang('Production based Earning')}}</option>
                        <option value="production_based_deduction">{{_lang('Production based Deduction')}}</option>
                    </select>
                    <span id="sata_parsley_error_employee_attendance_type_for_createing_attendance_type"></span>
                </div>
        
                {{-- Employee Attendance Type Status --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Attendance Type Is Active?')}} <span class="text-danger">*</span>
                    </label>
                    <select data-placeholder="Select Active Status" name="is_active" class="form-control select" id="is_active" required>
                        <option value="">Select Active Status</option>
                        <option selected value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
        
                {{-- Employee Attendance Type Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Attendance Type Description')}}
                    </label>
                    <textarea name="description" class="form-control" id="" placeholder="Enter Employee Attendance Type Description"></textarea>
                </div>
        
                @can('employee_attendance_type.create')
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>

<script>
    $('.select').select2({width:'100%'});
</script>