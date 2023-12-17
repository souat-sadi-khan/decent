<div class="row">
    {{-- Designation --}}
    <div class="col-md-12 form-group">
        <label for="designation">{{_lang('Designation')}} <span class="text-danger">*</span></label>
        <select name="designation" data-placeholder="Please Select One.." class="form-control select" id="designation" required>
            <option value="">Please Select One..</option>
            @foreach($designations as $designation)
                <option value="{{$designation->id}}" {{ ($designation->id == $model->designation_id)?'selected':'' }} >{{$designation->name}}</option>
            @endforeach
        </select>
    </div>

    {{-- Department --}}
    <div class="col-md-12 form-group">
        <label for="department">{{_lang('Department')}} <span class="text-danger">*</span> </label>
        <select name="department" data-placeholder="Please Select One.." class="form-control select" id="department" required>
            <option value="">Please Select One..</option>
            @foreach($departments as $department){
                <option value="{{$department->id}}" {{ ($department->id == $model->department_id)?'selected':'' }} >{{$department->name}}</option>
            @endforeach
        </select>
    </div>  

    {{-- Date Effective --}}
    <div class="col-md-12 form-group">
        <label for="data_effective">{{_lang('Date Effective')}} <span class="text-danger">*</span> </label>
        <input type="text" autocomplete="off" readonly="" name="data_effective" id="data_effective" class="form-control date" required value='{{ ($model->terms AND $model->terms->date_of_joining)?$model->terms->date_of_joining:""}}'>
    </div>

    {{-- employee  --}}
    <div class="col-md-12 form-group" style="display:none">
        <label for="employee_id">{{_lang('Employe ID')}} <span class="text-danger">*</span> </label>
        <input type="hidden" autocomplete="off" readonly="" name="employee_id" id="employee_id" class="form-control" required value="{{$id}}">
    </div>
       
    {{-- Remarks --}}
    <div class="col-md-12 form-group">
        <label for="remarks">{{_lang('Remarks')}} <span class="text-danger"> </span> </label>
        <input autocomplete="off" type="text" name="remarks" id="remarks" class="form-control" value="{{ $model->remarks}}" >
    </div>
    
    {{-- Upload Document --}}
    <div class="col-md-12 form-group">
        <label for="document">{{_lang('Upload Document')}} <span class="text-danger"> </span> </label>
        <input type="file" name="document" id="document" class="form-control" >
        @if ($model->document)   
        <a target="_blank" href="{{asset('storage/document')}}/{{$model->document}}" alt="Document Not Uploaded">Download/Open Document</a>
        @endif
    </div>
</div>