<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ _lang('Title') }}</th>
			<th>{{ _lang('Media') }}</th>
			<th>{{ _lang('Action') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($models as $element)
			<tr>
				<td>{{ $element->title }}</td>
				<td><img src="{{ asset('storage/marketing/media/'.$element->path) }}" alt="" border="0" width="120" class="img-rounded" align="center" ></td>
				<td><button class="btn btn-primary btn-sm" onclick="useMedia('{{ asset('storage/marketing/media/'.$element->path) }}')">Use</button></td>
			</tr>
		@endforeach
	</tbody>
</table>