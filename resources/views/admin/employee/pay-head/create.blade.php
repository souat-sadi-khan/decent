<div class="card">
    <div class="card-header">
        <h6>{{_lang('Create New Employee Pay Head')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-pay-head.store')}}" method="post" id="content_form">
            @csrf
            <div class="row">
                {{-- Employee Pay Head Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Pay Head Name')}} <span class="text-danger">*</span> </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Employee Pay Head Name" autocomplete="off" required>
                </div>
        
                {{-- Alias --}}
                <div class="col-md-6 form-group">
                    <label for="alias">{{_lang('Alias')}} <span class="text-danger">*</span> </label>
                    <input type="text" autocomplete="off" name="alias" id="alias" class="form-control" placeholder="Enter Alias" required>
                </div>
        
                {{-- Type --}}
                <div class="col-md-6 form-group">
                    <label for="type">{{_lang('Type')}} <span class="text-danger">*</span> </label>
                    <select data-parsley-errors-container="#parsley_error_employee_payhead_create_type_select" name="type" class="form-control select" data-placeholder="Select Employee Pay Head Type" id="type" required>
                        <option value="">Select Employee Pay Head Type.</option>
                        <option value="Earning">Earning</option>
                        <option value="Deduction">Deduction</option>
                    </select>
                    <span id="parsley_error_employee_payhead_create_type_select"></span>
                </div>
        
                {{-- Active Status --}}
                <div class="col-md-6 form-group">
                    <label for="is_active">{{_lang('Is Active ?')}} <span class="text-danger">*</span> </label>
                    <select data-parsley-errors-container="#parsley_error_employee_payhead_active_status_for_creating_pay_head" name="is_active" class="form-control select" id="is_active" data-placeholder="Select Active Status" required>
                        <option value="">Select Active Status</option>
                        <option selected value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <span id="parsley_error_employee_payhead_active_status_for_creating_pay_head"></span>
                </div>
        
                {{-- Pay Head Description --}}
                <div class="col-md-12 form-group">
                    <label for="description">{{_lang('Description')}}</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Enter Pay Head Description"></textarea>
                </div>
        
                @can('employee_payhead.create')
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2();
</script>