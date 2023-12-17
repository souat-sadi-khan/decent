<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Employee Attendance Type - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.attendance-attendance-type.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Employee Attendance Type Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Attendance Type Name')}} <span class="text-danger">*</span></label>
                    <input type="text" value="{{$model->name}}" name="name" id="name" class="form-control" placeholder="Enter Employee Attendance Type Name" required>
                </div>
        
                {{-- Employee Attendance Type Alias --}}
                <div class="col-md-6 form-group">
                    <label for="alias">{{_lang('Attendance Type Alias')}}
                    </label>
                    <input type="text" value="{{$model->alias}}" name="alias" id="alias" class="form-control"
                        placeholder="Enter Employee Attendance Type Alias" required>
                </div>
        
                {{-- Employee Attendance Type --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang(' Employee Attendance Type')}}
                    </label>
                    <select name="type" id="type" class="form-control select" data-placeholder="Select Attendance Type">
                        <option value="">{{_lang('Select Attendance Type')}}</option>
                        <option {{$model->type == 'Present' ? 'selected' : ''}} value="Present">{{_lang('Present')}}</option>
                        <option {{$model->type == 'Holiday' ? 'selected' : ''}} value="Holiday">{{_lang('Holiday')}}</option>
                        <option {{$model->type == 'On_leave' ? 'selected' : ''}} value="On_leave">{{_lang('On Leave Without pay - Absent')}}</option>
                        <option {{$model->type == 'Present_half_pay' ? 'selected' : ''}} value="Present_half_pay">{{_lang('Present with half day pay')}}</option>
                        <option {{$model->type == 'production_based_earning' ? 'selected' : ''}} value="production_based_earning">{{_lang('Production based Earning')}}</option>
                        <option {{$model->type == 'production_based_deduction' ? 'selected' : ''}} value="production_based_deduction">{{_lang('Production based Deduction')}}</option>
                    </select>
                </div>

                {{-- Employee Attendance Type Status --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Attendance Type Is Active?')}} <span class="text-danger">*</span>
                    </label>
                    <select data-placeholder="Select Active Status" name="is_active" class="form-control select" id="is_active" required>
                        <option value="">Select Active Status</option>
                        <option {{$model->is_active == '1' ? 'selected' : ''}} value="1">Active</option>
                        <option {{$model->is_active == '0' ? 'selected' : ''}} value="0">Inactive</option>
                    </select>
                </div>
        
                {{-- Employee Attendance Type Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Attendance Type Description')}}
                    </label>
                    <textarea name="description" class="form-control" id=""
                        placeholder="Enter Employee Attendance Type Description">{{$model->description}}</textarea>
        
                </div>
        
                @can('employee_attendance_type.update')
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2({  width: '100%' });
</script>