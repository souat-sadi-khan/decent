{!! Form::open(['route' => 'admin.language.create', 'id' => 'content_form','files' => true, 'method' => 'POST']) !!}
<div class="row">
	<div class="col-md-12">
		{{ Form::label('language_name', _lang('language_name') , ['class' => 'col-form-label required']) }}
	   	{{ Form::text('language_name', null, ['class' => 'form-control', 'placeholder' => _lang('language_name'),'required'=>'']) }}
	</div>
</div>

@can('language.create')
	<div class="text-right mt-2">
		<button data-placement="bottom" title="Create This Language" type="submit" class="btn btn-primary btn-lg"  id="submit">{{_lang('create')}}</button>
		<button type="button" class="btn btn-info" id="submiting" style="display: none;">{{ _lang('processing') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
	</div>
@endcan
{!!Form::close()!!}