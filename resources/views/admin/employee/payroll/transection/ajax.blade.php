@if ($val == '2')

    {{-- Bank Name --}}
    <div class="col-md-6 form-group">
        <label for="bank_name">{{_lang('Bank Name')}}</label>
        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Enter Bank Name" autocomplete="off" >
    </div>

    {{-- Account Holder Name --}}
    <div class="col-md-6 form-group">
        <label for="account_holder">{{_lang('Account Holder Name')}}</label>
        <input type="text" name="account_holder" id="account_holder" class="form-control" placeholder="Enter Account Holder Name" autocomplete="off">
    </div>

    {{-- Account Number --}}
    <div class="col-md-6 form-group">
        <label for="account_no">{{_lang('Account Number')}}</label>
        <input type="text" name="account_no" id="account_no" class="form-control" placeholder="Enter Account Number" autocomplete="off">
    </div>

    {{-- Check Number --}}
    <div class="col-md-6 form-group">
        <label for="check_no">{{_lang('Check Number')}}</label>
        <input type="text" name="check_no" id="check_no" class="form-control" placeholder="Enter Check Number" autocomplete="off">
    </div>

    {{-- Check Activation Date --}}
    <div class="col-md-12 form-group">
        <label for="check_active_date">{{_lang('Checck Active Date')}}</label>
        <input type="text" name="check_active_date" id="check_active_date" class="form-control date" placeholder="Etner Check Active Date" required readonly>
    </div>
    
@elseif($val == '3')

    {{-- Mobile Banking Name --}}
    <div class="col-md-6 form-group">
        <label for="mob_banking_name">{{_lang('Mobile Banking Name')}}</label>
        <input type="text" name="mob_banking_name" id="Mobile Banking Name" class="form-control" autocomplete="off" placeholder="Enter Mobile Banking Name">
    </div>

    {{-- Mobile Account Holder --}}
    <div class="col-md-6 form-group">
        <label for="mob_account_holder">{{_lang('Mobile Account Holder')}}</label>
        <input type="text" name="mob_account_holder" id="Mobile Account Holder" class="form-control" autocomplete="off" placeholder="Enter Mobile Account Holder" >
    </div>

    {{-- Sending Mobile Number --}}
    <div class="col-md-6 form-group">
        <label for="sending_mob_no">{{_lang('Sending Mobile Number')}}</label>
        <input type="text" name="sending_mob_no" id="sending_mob_no" class="form-control" autocomplete="off" placeholder="Enter Sending Mobile Number">
    </div>

    {{-- Receiving Mobile Number --}}
    <div class="col-md-6 form-group">
        <label for="receiving_mob_no">{{_lang('Receiving Mobile Number')}}</label>
        <input type="text" name="receiving_mob_no" id="receiving_mob_no" class="form-control" autocomplete="off" placeholder="Enter Receiving Mobile Number">
    </div>

    {{-- Mobile Transection ID --}}
    <div class="col-md-12 form-group">
        <label for="mob_tx_id">{{_lang('Transaction ID')}}</label>
        <input type="text" name="mob_tx_id" id="mob_tx_id" class="form-control" autocomplete="off" placeholder="Enter Transaction ID" required>
    </div>

@else 

@endif

<script>
    $('.date').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });
    
</script>