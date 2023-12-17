<div class="row">
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label for="field-1"
            class="control-label">{{ _lang('Subject') }}</label>
            <div class="col-md-12">
                <span class="form-control">{{ $model->subject }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1"
            class="control-label">{{ _lang('Email') }}</label>
            <div class="col-md-12">
                <textarea class="form-control">{{ $model->email_list }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="field-1"
            class="control-label">{{ _lang('Template') }}</label>
            <div class="col-md-12">
                {!! $model->template?$model->template->template:'' !!}
               
            </div>
        </div>
    </div>
</div>