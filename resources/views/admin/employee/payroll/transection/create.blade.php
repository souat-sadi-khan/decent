<div class="card">
    <div class="card-header">
        <h4 class="text-secondary text-center">{{_lang('Create New Payroll Transection')}}</h4>
    </div>
    <div class="card-body">
        <div style="position: absolute;top: 55%;left: 50%;z-index:100;  display: none;" id="loader_new">
            <img src="{{asset('loader_new.gif')}}" alt="">
        </div>

        <form action="{{route('admin.payroll-transection.store')}}" method="POST" id="content_form">
            @csrf
            <div class="row">

                {{-- Investment Account --}}
                <div class="col-md-12 form-group">
                    <label for="investment_account_id">Investment Account <span class="text-danger">*</span></label>
                    <select required name="investment_account_id" id="investment_account_id" class="form-control select" data-placeholder="Select Investment Account" data-parsley-errors-container="#investment_account_id_error">
                        <option value="">Select Investment Account</option>
                        @foreach ($accounts as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (<small>{{ $item->account_number}} </small> ) </option>
                        @endforeach
                    </select>
                    <span id="investment_account_id_error"></span>
                </div>

                {{-- Head --}}
                <div class="col-md-12 form-group">
                    <label for="head">{{_lang('Head')}}</label>
                    <select name="head" id="head" class="form-control select" data-placeholder="Choose Pay Head" required>
                        <option value="">{{_lang('Choose Pay Head')}}</option>
                        <option selected value="Salary Payment">{{_lang('Salary Payment')}}</option>
                        <option value="Advance Payment">{{_lang('Advance Payment')}}</option>
                        <option value="Advance Return">{{_lang('Advance Return')}}</option>
                        <option value="Other Payment">{{_lang('Other Payment')}}</option>
                    </select>
                </div>

                {{-- Employee List --}}
                <div class="col-md-6 form-group">
                    <label for="employee_id">{{_lang('Employee')}}</label>
                    <select data-url="{{route('admin.check_employee_payroll')}} " name="employee_id" id="employee_id" class="form-control select" required data-placeholder="Select Employee" data-parsley-errors-container="#employee_id_error">
                        <option value="">{{_lang('Select Employee')}}</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}} ({{$employee->prefix.numer_padding($employee->code, get_option('digits_employee_code'))}}) </option>
                        @endforeach
                    </select>
                    <span id="employee_id_error"></span>
                </div>

                {{-- Date of Transection --}}
                <div class="col-md-6 form-group">
                    <label for="date">{{_lang('Date of Transaction')}}</label>
                    <input type="text" name="date" id="date" class="form-control date" placeholder="Enter Date of Transaction" required  readonly>
                </div>

                <div class="input-group col-md-12 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'}} </span>
                    </div>
                    <input autocomplete="off" type="number" class="form-control" name="amount" placeholder="Enter Amount" required data-parsley-errors-container="#amount_parsley_error">       

                    <select data-url="{{route('admin.check_payment_method')}} " data-placeholder="Select Payment Methhod" name="payment_method" id="payment_method" class="form-control select" data-parsley-errors-container="#payment_method_error">
                        <option value="">{{_lang('Select Payment Methhod')}}</option>
                        <option value="1">{{_lang('Cash')}}</option>
                        <option value="2">{{_lang('Bank Check')}}</option>
                        <option value="3">{{_lang('Mobile Banking')}}</option>
                    </select>
                    
                </div><span id="payment_method_error"></span>
                <span id="amount_parsley_error"></span>

                <div class="row col-md-12" id="payment_method_gateway"></div>

                {{-- Document --}}
                <div class="col-md-12 form-group">
                    <label for="document">{{_lang('Document')}}</label>
                    <input type="file" class="form-control" id="document" name="document">
                </div>

                {{-- Remarks --}}
                <div class="col-md-12 form-group">
                    <label for="additional_note">{{_lang('Remarks')}}</label>
                    <textarea name="additional_note" id="additional_note" cols="30" rows="2" class="form-control" ></textarea>
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
    $('.select').select2();
    $('.date').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    $('#head').change(function() {
        $('#employee_id').val('').trigger('change');
        $('#employee_id_error').html('');
    });

    $('#employee_id').change(function() {
        var val = $(this).val();
        var head = $('#head').val();
        var url = $(this).data('url');
        if(head == 'Salary Payment') {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    val: val
                },
                beforeSend: function() {
                    $('#loader_new').fadeIn();
                }, 
                success: function (data) {
                    $('#employee_id_error').html(data);
                    $('#loader_new').fadeOut();
                }
            });
        } else if (head == 'Advance Return') {
            $.ajax({
                type: 'POST',
                url: '/admin/check_advane_return',
                data: {
                    val: val
                },
                beforeSend: function() {
                    $('#loader_new').fadeIn();
                }, 
                success: function (data) {
                    $('#employee_id_error').html(data);
                
                    $('#loader_new').fadeOut();
                }
            });
        }
    });

    $('#payment_method').change(function() {
        var val = $(this).val();
        var url = $(this).data('url');
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                val: val
            },
            beforeSend: function() {
                $('#loader_new').fadeIn();
            }, 
            success: function (data) {
                $('#payment_method_gateway').html(data);
                $('#loader_new').fadeOut();
            }
        });
    });

</script>