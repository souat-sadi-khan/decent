<form action="{{route('admin.employee-leave-request.store')}}" method="post" id="content_form" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group" id="employee_other">
                <label class="custom-control custom-checkbox mt-2">
                    <input type="checkbox" id="checkbox" value="" class="custom-control-input">
                    <span class="custom-control-label">Apply Leave for Other Employee</span>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- Employee --}}
        <div class="col-md-6 form-group" id="employee_show" style="display:none">
            <label for="name">{{_lang('Employee')}} <span class="text-danger">*</span> </label>
            <select data-parsley-errors-container="#data_parsley_employee_leave_request_create" data-placeholder="Please Select One" name="employee" id="employee" class="form-control select"
                >
                <option value="">Please Select One</option>
                @foreach ($models as $employee)
                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                @endforeach
            </select>
            <span id="data_parsley_employee_leave_request_create"></span>
        </div>

        {{-- Leave Type --}}
        <div class="col-md-6 form-group">
            <label for="leave_type">{{_lang('Leave Type')}} <span class="text-danger">*</span> </label>
            <select data-parsley-errors-container="#parsley_error_request_create_leave_type" data-placeholder="Please Select One" name="leave_type" id="leave_type" class="form-control select"
                required>
                <option value="">Please Select One</option>
                @foreach ($leave_types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>
            <span id="parsley_error_request_create_leave_type"></span>
        </div>
    </div>
    <div class="row">
        {{-- Start Date --}}
        <div class="col-md-6 form-group">
            <label for="start_date">{{_lang('Start Date')}} <span class="text-danger">*</span> </label>
            <input type="text" name="start_date" id="start_date" class="form-control date" placeholder="Start Date" required>
        </div>

        {{-- End Date --}}
        <div class="col-md-6 form-group">
            <label for="end_date">{{_lang('End Date')}} <span class="text-danger">*</span> </label>
            <input type="text" name="end_date" id="end_date" class="form-control date" placeholder="End Date" required>
        </div>

        {{--Reason --}}
        <div class="col-md-12 form-group">
            <label for="name">{{_lang('Reason')}} <span class="text-danger">*</span> </label>
            <textarea name="reason" required class="form-control" id="" placeholder="Enter Reason"></textarea>
        </div>

        {{-- Document --}}
        <div class="col-md-12 form-group">
            <label for="file">{{_lang('Upload Document')}} </label>
            <input type="file" name="file" id="file" class="form-control">
        </div>

        <div class="form-group col-md-12" align="right">
            <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('.select').select2({
        width: '100%'
    });

    $(document).on('change', '#employee_other', function() {
        if($('#checkbox').prop("checked") == true){
                $('#employee_show').show('slow');
                $("#employee").prop('required',true);
            }
            else if($('#checkbox').prop("checked") == false){
                $('#employee_show').hide('slow');
                $("#employee").prop('required',false);
            }
    });
</script>