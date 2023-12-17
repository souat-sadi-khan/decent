<div class="row p-4">
    <div class="col-md-12">
        <form action="{{route('admin.employee.basic_info.update')}}" class="basic_form" method="post">
            @csrf 
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="prefix">{{_lang('Prefix & Code')}} <span class="text-danger">*</span>
                    </label>
                    <div class="row">
                        <div class="col-md-4">
                            <input readonly type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix" value="{{$model->prefix}}" required>
                        </div>
                        <div class="col-md-8"> 
                            <input readonly type="text" name="code" id="code" class="form-control" placeholder="Code Here" required value="{{$model->code}}">
                        </div>
                    </div>
                </div>
        
                {{-- Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Name')}} <span class="text-danger">*</span> </label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Enter Name" required value="{{$model->name}}">
                </div>

                {{-- Shift --}}
                <div class="col-md-6 form-group">
                    <label for="shift">{{_lang('Shift')}} <span class="text-danger">*</span> </label>
                    @php
                        $shifts = App\Models\Employee\EmployeeShift::where('status', 1)->get();
                    @endphp
                    <select name="shift" id="shift" class="form-control select" data-placeholder="Select Shift" required>
                        <option value="">{{_lang('Select Shift')}}</option>
                        @foreach ($shifts as $item)
                            <option {{$item->id == $model->shift_id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                {{-- Date Of Birth --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Date Of Birth')}} <span class="text-danger">*</span> </label>
                    <input type="text" autocomplete="off" readonly="" name="date_of_birth" id="date_of_birth" class="form-control date"  value="{{$model->date_of_birth}}">
                </div>
        
                {{-- Date Of Anniversary --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Date Of Anniversary')}} </label>
                    <input type="text" name="date_of_anniversary" autocomplete="off" readonly="" id="date_of_anniversary" class="form-control date"  value="{{$model->date_of_anniversary}}">
                </div>
        
                {{-- Gender --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Gender')}} <span class="text-danger">*</span> </label>
                    
                    <select data-placeholder="Please Select One.." name="gender" id="gender" class="form-control select" required>
                        <option value="">Please Select One..</option>
                        <option {{$model->gender == 'Male' ? 'selected' : ''}} value="Male">Male</option>
                        <option {{$model->gender == 'Female' ? 'selected' : ''}} value="Female">Female</option>
                        <option {{$model->gender == 'Other' ? 'selected' : ''}} value="Other">Other</option>
                    </select>
                </div>    
        
                {{-- Marital Status --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang(' Marital Status')}} </label>
                    <select data-placeholder="Please Select One" name="marital_status" id="marital_status" class="form-control select" >
                        <option value="">Please Select One..</option>
                        <option {{$model->marital_status == 'Unmarried' ? 'selected' : ''}} value="Unmarried">Unmarried</option>
                        <option {{$model->marital_status == 'Married' ? 'selected' : ''}} value="Married">Married</option>
                        <option {{$model->marital_status == 'Separete' ? 'selected' : ''}} value="Separete">Separete</option>
                        <option {{$model->marital_status == 'Divorced' ? 'selected' : ''}} value="Divorced">Divorced</option>
                        <option {{$model->marital_status == 'Widow' ? 'selected' : ''}} value="Widow">Widow</option>
                    </select>
                </div>
                
                {{-- Nationality --}}
                <div class="col-md-6 form-group">
                    <label for="nationality">{{_lang('Nationality')}} </label>
                    <input autocomplete="off" type="text" name="nationality" id="nationality" class="form-control"
                    placeholder="Enter Employee Nationality"  value="{{$model->nationality != '' ? $model->nationality : 'Bangladeshi'}}">
                </div>   
        
                {{-- Mother Tongue --}}
                <div class="col-md-6 form-group">
                    <label for="mother_tongue">{{_lang('Mother Tongue')}} </label>
                    <input autocomplete="off" type="text" name="mother_tongue" id="mother_tongue" class="form-control" placeholder="Enter Employee Mother Tongue"  value="{{$model->mother_tongue != '' ? $model->mother_tongue : 'Bengoly'}}">
                </div>   
        
                {{-- Father Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Father Name')}} </label>
                    <input type="text" name="father_name" id="father_name" class="form-control" autocomplete="off" placeholder="Enter Father Name" value="{{$model->father_name}}">
                </div>
        
                {{-- Mother Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Mother Name')}} </label>
                    <input type="text" name="mother_name" id="mother_name" class="form-control" autocomplete="off" placeholder="Enter Mother Name" value="{{$model->mother_name}}" >
                </div>
        
                <div class="form-group col-md-12" align="right">
                    <input type="hidden" name="id" value="{{$model->id}}">
                    <button type="submit" class="btn btn-primary btn-sm" id="submit">{{_lang('Save')}}<i class="fa ml-2 fa-crosshairs" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                </div>
                
            </div>
        </form>
    </div>
</div>

<script>
    $('.select').select2({ width: '100%' });

    var _basicInfoValidation = function() {
        if ($('.basic_form').length > 0) {
            $('.basic_form').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
        }
        $('.basic_form').on('submit', function(e) {
            e.preventDefault();
            $('#submit').hide();
            $('#submiting').show();
            $(".ajax_error").remove();
            var submit_url = $(this).attr('action');
            console.log(submit_url);
            //Start Ajax
            var formData = new FormData($(this)[0]);
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

                    } else {
                        toastr.success(data.message);
                        $('#submit').show();
                        $('#submiting').hide();
                        if (data.goto) {
                            setTimeout(function() {

                                window.location.href = data.goto;
                            }, 2500);
                        }

                        if (data.load) {
                            setTimeout(function() {

                                window.location.href ="";
                            }, 2500);
                        }
                        if (data.window) {
                            window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                            setTimeout(function() {
                                window.location.href = '';
                            }, 1000);
                        }

                        if (data.windowup) {
                            window.open(data.windowup, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                            setTimeout(function() {
                                window.location.href = data.back;
                            }, 1000);
                        }
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
                            if ($('#' + first_item + '_error').length > 0) {
                                $('#' + first_item + '_error').html('<span style="color:red" class="ajax_error">' + value + '</span>');
                            } else {
                                $('#' + first_item).after('<span style="color:red" class="ajax_error">' + value + '</span>');
                            }

                            toastr.error(value);
                            i++;
                        });
                    } else {
                        toastr.error(jsonValue.message);
                    }
                    $('#submit').show();
                    $('#submiting').hide();
                }
            });
        });
    };
    _basicInfoValidation();
    _componentDatefPicker();
</script>