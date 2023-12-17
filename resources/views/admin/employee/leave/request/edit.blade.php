<form action="{{route('admin.employee-leave-request.update', $model->id)}}" method="post" id="content_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Employee --}}
        <div class="col-md-6 form-group">
            <h6 class="mt-3">
                {{$model->employee->name}} ({{$model->employee->prefix}}{{numer_padding($model->employee->code, get_option('digits_employee_code'))}}) <br>
                {{current_designation($model->employee_id)}} <br></h6>
        </div>

        {{-- Leave Type --}}
        <div class="col-md-6 form-group">
            <label for="leave_type">{{_lang('Leave Type')}} <span class="text-danger">*</span>
            </label>
            <select  data-placeholder="Please Select One" name="leave_type" id="leave_type" class="form-control select"
                required>
                <option value="">Please Select One</option>
                @foreach ($leave_types as $type)
                <option {{$model->employee_leave_type_id == $type->id?'selected':''}} value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>
        </div>

        {{-- Start Date --}}
        <div class="col-md-6 form-group">
            <label for="start_date">{{_lang('Start Date')}} <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->start_date}}" name="start_date" id="start_date" class="form-control date" placeholder="Start Date"
                required>
        </div>

        {{-- End Date --}}
        <div class="col-md-6 form-group">
            <label for="end_date">{{_lang('End Date')}} <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->end_date}}" name="end_date" id="end_date" class="form-control date" placeholder="End Date" required>
        </div>
        
        {{--Reason --}}
        <div class="col-md-12 form-group">
            <label for="name">{{_lang('Reason')}} <span class="text-danger">*</span>
            </label>
            <textarea name="reason" required class="form-control" id="" placeholder="Enter Reason">{{$model->reason}}</textarea>
        </div>

        {{-- Document --}}
        <div class="col-md-12 form-group">
            <label for="file">{{_lang('Upload Document')}}
            </label>
            <input type="hidden" name="old_file" id="file" value="{{$model->upload_token}}" class="form-control">
            <input type="file" name="file" id="file" class="form-control">
        </div>

        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}
                <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('.date').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true
    });
    $('.select').select2({
        width: '100%'
    });

</script>
