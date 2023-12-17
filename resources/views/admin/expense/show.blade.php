<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ _lang('Expense Category') }}</th>
			<th>{{ $model->category->name }}</th>
		</tr>
		<tr>
			<th>{{ _lang('Reason') }}</th>
			<th>{{ $model->reson }}</th>
		</tr>

		<tr>
			<th>{{ _lang('Note') }}</th>
			<th>{{ $model->note }}</th>
		</tr>
		<tr>
			<th>{{ _lang('Amount') }}</th>
			<th>{{ $model->amount }}</th>
		</tr>

		<tr>
			<th>{{ _lang('Date') }}</th>
			<th>{{formatDate($model->date)}}</th>
		</tr>
	</thead>
</table>

<button class="btn btn-outline btn-success btn-round btn-wd w-100"> <i class="fa fa-print" aria-hidden="true"></i></button>