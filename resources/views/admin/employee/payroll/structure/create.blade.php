<div class="card">
    <div class="card-header">
        <h6>{{_lang('Create New Salary Structure for Employee')}} </h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.payroll-s-structure.store')}}" method="POST" id="content_form">
            @csrf 
            <div class="row">
                {{-- Employee --}}
                <div class="col-md-6 form-group">
                    <label for="employee_id">{{_lang('Employee')}}</label>
                    <select name="employee_id" id="employee_id" class="form-control select" data-placeholder="Select Employee First" required data-parsley-errors-container='#parsley_error_for_creaeing_salary_structure_employee'>
                        <option value="">{{_lang('Select Employee First')}}</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}} ({{$employee->prefix}}{{$employee->code}}) </option>
                        @endforeach
                    </select>
                    <span id="parsley_error_for_creaeing_salary_structure_employee"></span>
                </div>
                {{-- Date Iffective --}}
                <div class="col-md-6 form-group">
                    <label for="date_effective">{{_lang('Date Effective')}}</label>
                    <input type="text" name="date_effective" id="date_effective" class="form-control date" placeholder="Enter Date Effective" required>
                </div>
                {{-- Template --}}
                <div style="position: absolute;top: 55%;left: 50%;z-index:100;  display: none;" id="loader_new">
                    <img src="{{asset('loader_new.gif')}}" alt="">
                </div>

                <div class="col-md-12 form-group">
                    <label for="payroll_template_id">{{_lang('Payroll Template')}}</label>
                    <select required data-url="{{route('admin.employee-s-structure.ajax')}} " name="payroll_template_id" id="payroll_template_id" class="form-control select" data-placeholder="Select Payroll Template" data-parsley-errors-container="#parsley_error_for_creating_salary_structure_template">
                        <option value="">{{_lang('Select Payroll Template')}}</option>
                        @foreach ($templates as $template)
                            <option value="{{$template->id}}">{{$template->name}}</option>
                        @endforeach
                    </select>
                    <span id="parsley_error_for_creating_salary_structure_template"></span>
                </div>
                <div id="data" class="col-md-12" style="display:none;"></div>
                {{-- Descritption --}}
                <div class="col-md-12 form-group">
                    <label for="description">{{_lang('Description')}}</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="2" placeholder="Enter Description"></textarea>
                </div>
            </div>
            
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2({width:'100%'});

    $(function() {
        $('#payroll_template_id').change(function() {
            var id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                },
                beforeSend: function() {
                    $('#loader_new').fadeIn();
                    $('#data').fadeOut('slow');
                }, 
                success: function (data) {
                    $('#data').html(data);
                    $('#data').fadeIn('slow');
                    $('#loader_new').fadeOut();
                    // _componentRemoteModalLoadAfterAjax();
                }
            });
        });
    });
</script>