@extends('layouts.app', ['title' => _lang('Sale Return'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title=""><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Sale Return')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-10 mx-auto ">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <label for="transaction_id">Sale Reference <span class="text-danger"></span></label>
                        <select data-parsley-errors-container="#transaction_error" required name="transaction_id" id="transaction_id" class="form-control select" data-placeholder="Select Transaction Reference">
                            <option value="">Select Transaction Reference</option>
                            @foreach ($transaction as $element)
                            <option value="{{ $element->id }}">{{ $element->reference_no }}</option>
                            @endforeach
                        </select>
                        <span id="transaction_error"></span>
                    </div>
                </div>
                <div class="row mt-2">
                     <div class="col-md-6 mx-auto text-center">
                        
                        <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Check Transaction</button>
                        <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
$(document).on('click', '#check_it', function() {
    var transaction_id = $('#transaction_id').val();
    $(this).hide();
    $('#checking').show();
    if (transaction_id=="") {
      $(this).show();
      $('#checking').hide();
      toastr.error('Select Purchase References');
    }else{
     $.ajax({
            url: '/admin/sale/return-check',
            data: {
                transaction_id: transaction_id,
            },
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
           $(this).show();
           $('#checking').hide();
           toastr.success(data.message);
            if (data.goto) {
                setTimeout(function() {

                    window.location.href = data.goto;
                }, 500);
            }
        })
    }

});
</script>
@endpush