@extends('layouts.app', ['title' => _lang('Employee Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
	<div>
		<h1 data-placement="bottom" title="Other Payment Report."><i class="fa fa-universal-access mr-4"></i>
		{{_lang('Employee Report')}}</h1>
	</div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
	<div class="card-header">
		<h6>{{_lang('Employee AdvOther Paymentn Report')}}</h6>
	</div>
	<div class="card-body">
        <div class="row">
            <div class="col-md-8 mx-auto form-group">
                <label for="employee_id">{{_lang('Employee')}}</label>
                <select name="employee_id" id="employee_id" class="form-control select">
                    <option value="All">All Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}({{ $employee->mobile }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 form-group">
                <label for="sDate">{{_lang('Start Date')}}</label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control date" name="sDate" id="sDate" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="eDate">{{_lang('End Date')}}</label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control date" name="eDate" id="eDate" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <button data-url="{{ route('admin.report.employee-report-ajax')}} " type="button" id="submit" class="btn btn-block btn-info">{{ _lang('Get Sales Report') }}</button>
                <button style="display: none;" type="button" id="submiting" class="btn btn-block btn-info" disabled>{{ _lang('Processing...') }}</button>
            </div>
        </div>
	</div>
</div>

<div class="card mt-3">
    <div class="card-header">Requested Report</div>
    <div id="report_data" class="card-body">

    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
_componentDatefPicker();

$(function() {
    $('#submit').hide();
    $('#submiting').show();
    var employee_id = $('#employee_id').val();
    var start_date = $('#sDate').val();
    var end_date = $('#eDate').val();


    get_data(employee_id, start_date, end_date);
});

$('#submit').click(function() {
    $('#submit').hide();
    $('#submiting').show();
    var employee_id = $('#employee_id').val();
    var start_date = $('#sDate').val();
    var end_date = $('#eDate').val();


    get_data(employee_id, start_date, end_date);
});

function get_data(employee_id, start_date, end_date) {
    var url = $('#submit').data('url');
    
    $.ajax({
        url: url,
        data: {
            employee_id: employee_id,
            start_date: start_date,
            end_date: end_date
        },
        type: 'POST',
        dataType: 'html'
    })
    .done(function(data) {
        $('#report_data').html(data);
        toastr.success('Report Genarate');
        $('#submit').show();
        $('#submiting').hide();
    });
}
</script>
@endpush