<div class="row">
    {{-- standard --}}
    <div class="col-md-6 form-group">
        <label for="standard">{{_lang('Standard')}} <span class="text-danger">*</span></label>
        <input autocomplete="off" type="text" name="standard" id="standard" placeholder="Enter Standart" class="form-control" value="{{$model->standard}}" required>
    </div>

    {{-- institute_name --}}
    <div class="col-md-6 form-group">
        <label for="institute_name">{{_lang('Institute Name')}} <span class="text-danger">*</span></label>
        <input autocomplete="off" type="text" name="institute_name" id="institute_name" placeholder="Enter Institute Name" class="form-control" value="{{$model->institute_name}}" required>
    </div>

    {{-- board_name --}}
    <div class="col-md-6 form-group">
        <label for="board_name">{{_lang('Board Name')}} <span class="text-danger">*</span></label>
        <input autocomplete="off" type="text" name="board_name" id="board_name" placeholder="Enter Borad Name" class="form-control" value="{{$model->board_name}}" required>
    </div>

    {{-- start_period --}}
    <div class="col-md-6 form-group">
        <label for="start_period">{{_lang('Start Period')}} <span class="text-danger">*</span></label>
        <input type="text" name="start_period" id="start_period" placeholder="Enter Start Period" class="form-control date" value="{{$model->start_period}}" required>
    </div>

    {{-- end_period --}}
    <div class="col-md-6 form-group">
        <label for="end_period">{{_lang('End Period')}}</label>
        <input type="text" name="end_period" id="end_period" placeholder="Enter End Period" class="form-control date" value="{{$model->end_period}}">
    </div>

    {{-- result --}}
    <div class="col-md-6 form-group">
        <label for="result">{{_lang('Result')}} <span class="text-danger">*</span></label>
        <input autocomplete="off" type="text" name="result" id="result" placeholder="Enter Result" class="form-control" value="{{$model->result}}" required>
    </div>

    {{-- Description --}}
    <div class="col-md-12 form-group">
        <label for="description">{{_lang('Description')}}</label>
        <textarea name="description" id="description" class="form-control" placeholder="Enter Description" cols="30" rows="2">{{$model->description}}</textarea>
    </div>
</div>
<input type="hidden" name="employee_id" value="{{$employee_id}}">