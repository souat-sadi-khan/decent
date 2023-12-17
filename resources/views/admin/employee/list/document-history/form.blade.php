<div class="row">
    {{-- Employee Document Type --}}
    <div class="col-md-6 form-group">
        <label for="employee_document_type_id">{{_lang('Select Employee Document Type')}}  <span class="text-danger">*</span> </label>
        <select data-parsley-errors-container="#employee_document_type_id_error" name="employee_document_type_id" id="employee_document_type_id" required class="form-control select" data-placeholder="Select One">
            <option value="">{{_lang('Select One')}}</option>
            @foreach ($employee_document_types as $item)
                <option value="{{$item->id}}" {{$item->id == $model->employee_document_type_id ? 'selected' : ''}} >{{$item->name}}</option>
            @endforeach
        </select>
        <span id="employee_document_type_id_error"></span>
    </div>

    {{-- Title --}}
    <div class="col-md-6 form-group">
        <label for="title">{{_lang('Title')}} <span class="text-danger">*</span></label>
        <input type="text" autocomplete="off" name="title" id="title" class="form-control" placeholder="Enter Document Title" required value="{{$model->title}}"> 
    </div>

    {{-- Description --}}
    <div class="col-md-12 form-group">
        <label for="description">{{_lang('Description')}}</label>
        <textarea name="description" id="description" cols="30" rows="2" class="form-control" placeholder="Enter Document Description" >{{$model->description}}</textarea>
    </div>

    {{-- File --}}
    <div class="col-md-12 form-group">
        <label for="file">{{_lang('Document File')}} <span class="text-danger">*</span></label>
        <input type="file" name="file" class="form-control" id="file">
    </div>

    @if ($model->upload_token != '') 
        <div class="col-md-12">
            <a target="_blank" href="{{asset('storage/document')}}/{{$model->upload_token}}" alt="Document Not Uploaded"><i class="fa fa-folder-open mr-2" aria-hidden="true"></i> The Document File</a>
        </div>
    @endif
</div>

<div class="form-group col-md-12" align="right">
    <input type="hidden" name="employee_id" value="{{$employee_id}}">
    <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create/Save')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
    <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
</div>