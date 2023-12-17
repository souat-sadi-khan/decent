@extends('layouts.app', ['title' => _lang('Expense Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
	<div>
		<h1 data-placement="bottom" title="Expense Report."><i class="fa fa-universal-access mr-4"></i>
		{{_lang('Report')}}</h1>
	</div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
	<div class="card-header">
		<h6>{{_lang('Expense Report')}}</h6>
	</div>
	<div class="card-body">
		<form action="{{route('admin.report.expense.get_expense_report')}}" method="post" enctype="multipart/form-data" target="_blank">


			@csrf
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="expense_category_id">{{_lang('Expense Category')}}</label>
                  <select name="expense_category_id" id="expense_category_id" class="form-control select">
                  	<option value="All">All Expense Category</option>
                  	@foreach ($categories as $element)
                  		<option value="{{ $element->id }}">{{ $element->name }}</option>
                  	@endforeach
                  </select>
				</div>

				<div class="col-md-4 form-group">
					<label for="investment_account_id">{{_lang('Investment Account')}}</label>
                  <select name="investment_account_id" id="investment_account_id" class="form-control select">
                  	<option value="All">All Invest Account</option>
                  	@foreach ($invest_accounts as $account)
                  		<option value="{{ $account->id }}">{{ $account->name}}-{{  $account->account_number }}</option>
                  	@endforeach
                  </select>
				</div>

				<div class="col-md-4 form-group">
					<label for="user_id">{{_lang('User')}}</label>
                  <select name="user_id" id="user_id" class="form-control select">
                  	<option value="All">All User</option>
                  	@foreach ($users as $user)
                  		<option value="{{ $user->id }}">{{ $user->email }}</option>
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

					<button id="submit" type="button" data-url="{{route('admin.report.expense.get_expense_report')}}" class="btn btn-block btn-info">{{ _lang('Get Expense Report') }}</button>
					<button style="display: none;" id="submiting" type="button" disabled class="btn btn-block btn-info">{{ _lang(' Processing... ') }}</button>

				</div>
			</div>
		</form>
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

	var expense_category_id = $('#expense_category_id').val();
	var investment_account_id = $('#investment_account_id').val();
	var user_id = $('#user_id').val();
	var sDate = $('#sDate').val();
	var eDate = $('#eDate').val();

	get_data(expense_category_id, investment_account_id, user_id, sDate, eDate);
});

$('#submit').click(function() {
	$('#submit').hide();
	$('#submiting').show();

	var expense_category_id = $('#expense_category_id').val();
	var investment_account_id = $('#investment_account_id').val();
	var user_id = $('#user_id').val();
	var sDate = $('#sDate').val();
	var eDate = $('#eDate').val();

	get_data(expense_category_id, investment_account_id, user_id, sDate, eDate);
});

function get_data(expense_category_id, investment_account_id, user_id, sDate, eDate) {
	var url = $('#submit').data('url');
	$.ajax({
        url: url,
        data: {
            expense_category_id: expense_category_id,
            investment_account_id: investment_account_id,
            user_id: user_id,
            sDate: sDate,
            eDate: eDate
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
