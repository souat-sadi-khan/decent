<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Employee Leave Allocation Information')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-leave-allocation.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Employee --}}
                <div class="col-md-6 form-group">
                    <h6 class="mt-3">
                        {{$model->employee->name}} ({{$model->employee->prefix}}{{numer_padding($model->employee->code, get_option('digits_employee_code'))}}) <br>
                        {{current_designation($model->employee_id)}} <br></h6>
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
        
        
                @foreach ($model->allocation_details as $type)
                <div class="col-md-6 form-group">
                    <label for="leave_type_{{$type->id}}">{{$type->leave_type->name}} <span class="text-danger">*</span>
                    </label>
                <input type="text" name="leave_type[{{$type->id}}]" value="{{$type->allotted}}" id="leave_type_{{$type->leave_type->id}}" class="form-control"
                        placeholder="Leave Allotted" required>
                </div>
                @endforeach
        
        
        
                {{--Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Description')}} <span class="text-danger">*</span>
                    </label>
                    <textarea name="description" class="form-control" id="" placeholder="Enter Description">{{$model->description}}</textarea>
        
                </div>
        
                @can('employee_leave_request.update')
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>
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
