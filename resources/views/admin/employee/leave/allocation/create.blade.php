<div class="card">
    <div class="card-header">
        <h6>{{_lang('Create New Employee Leave Allocation')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-leave-allocation.store')}}" method="post" id="content_form">
            @csrf
            <div class="row">
                {{-- Employee --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Employee')}} <span class="text-danger">*</span>
                    </label>
                    <select data-parsley-errors-container="#parsley_leave_allocation_create_employee" data-placeholder="Please Select One" name="employee" id="employee" class="form-control select" required>
                        <option value="">Please Select One</option>
                        @foreach ($models as $employee)
                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                        @endforeach
                    </select>
                    <span id="parsley_leave_allocation_create_employee"></span>
                </div>
        
                {{-- Start Date --}}
                <div class="col-md-6 form-group">
                    <label for="start_date">{{_lang('Start Date')}} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="start_date" id="start_date" class="form-control date" placeholder="Start Date" required>
                </div>
        
                {{-- End Date --}}
                <div class="col-md-6 form-group">
                    <label for="end_date">{{_lang('End Date')}} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="end_date" id="end_date" class="form-control date" placeholder="End Date" required>
                </div>
        
        
                 @foreach ($leave_types as $type)
                    <div class="col-md-6 form-group">
                        <label for="leave_type_{{$type->id}}">{{$type->name}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="leave_type[{{$type->id}}]" id="leave_type_{{$type->id}}" class="form-control" placeholder="Leave Allotted" required>
                    </div>
                @endforeach
        
                
        
                {{--Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Description')}}
                    </label>
                    <textarea name="description" class="form-control" id="" placeholder="Enter Description"></textarea>
                </div>
        
                @can('employee_leave_request.create')
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.select').select2({ width: '100%' });
</script>