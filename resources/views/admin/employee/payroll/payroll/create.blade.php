<div class="card">
    <div class="card-header">
        <h4 class="text-center">
            {{_lang('Iniatialize New Employee Payroll ')}}
        </h4>
    </div>
    <div class="card-body" id="data34">
        <div class="data-item">
            <form action="{{route('admin.payroll-initialize.step_one')}}" method="POST" id="step_one_submit">
                @csrf
                <div class="row">
    
                    {{-- Employee ID --}}
                    <div class="col-md-12 form-group">
                        <label for="employee_id">{{_lang('Select Employee')}}</label>
                        <select data-parsley-errors-container="#select_error_for_employee" name="employee_id" id="employee_id" class="form-control select" required data-placeholder="Select Employee First">
                            <option value="">{{_lang('Select Employee First')}}</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}"> <strong>{{$employee->name}}</strong>  ( {{$employee->prefix}}{{$employee->code}}  ) </option>
                            @endforeach
                        </select>
                        <span id="select_error_for_employee"></span>
                    </div>
    
                    {{-- Start Date --}}
                    <div class="col-md-12 form-group">
                        <label for="start_date">{{_lang('Start Date')}}</label>
                        <input type="text" name="start_date" id="start_date" class="form-control date" required placeholder="Select Start Date" readonly>
                    </div>
    
                    {{-- End Date --}}
                    <div class="col-md-12 form-group">
                        <label for="end_date">{{_lang('End Date')}}</label>
                        <input type="text" name="end_date" id="end_date" class="form-control date" required placeholder="Select End Date" readonly>
                    </div>
    
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary btn-sm" id="submit" type="submit" >Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

// select 2
$('.select').select2();

// Date
$('.date').datepicker({
    dateFormat: "yy-mm-dd",
    autoclose: true,
    todayHighlight: true
});


var _StepOneSubmit = function() {
    if ($('#step_one_submit').length > 0) {
        $('#step_one_submit').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#step_one_submit').on('submit', function(e) {
        e.preventDefault();
        $('#submit').attr('disabled', 1);
        $('#submit').html('Processing...');
        $(".ajax_error").remove();
        var submit_url = $('#step_one_submit').attr('action');
        //Start Ajax
        var formData = new FormData($("#step_one_submit")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {

                if (data.status == 'danger') {

                    toastr.error(data.message);

                    $('#submit').removeAttr('disabled');

                    $('#submit').html('Next');

                } else {
                    
                    $('.data-item').fadeOut();

                    toastr.success(data.message);

                }

                if(data.html) {

                    $('#data34').html(data.html);

                }

                

            },
            error: function(data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function(key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.warning(jsonValue.message);

                }
                _componentSelect2Normal();

                $('#submit').removeAttr('disabled');

                $('#submit').html('Next');
                
            }
        });
    });
};

_StepOneSubmit();

</script>