<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Employee Document Type - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-leave-type.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Employee Leave Type Name --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Leave Type Name')}} <span class="text-danger">*</span> </label>
                    <input autocomplete="off" type="text" name="name" value="{{$model->name}}" id="name" class="form-control" placeholder="Enter Leave Type Name" required>
                </div>
        
                 {{-- Alias --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Alias')}} <span class="text-danger">*</span> </label>
                    <input style="text-transform: uppercase;" autocomplete="off" type="text" name="alias" id="alias" class="form-control" placeholder="Enter Alias" required value="{{$model->alias}}">
                </div>

                {{-- Active Status --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Is Active ?')}} <span class="text-danger">*</span> </label>
                    <select data-placeholder="Select Active Status" name="is_active" class="form-control select" id="is_active" required>
                        <option value="">Select Active Status</option>
                        <option value="1" {{$model->is_active == 1?"selected":""}}>Active</option>
                        <option value="0" {{ $model->is_active == 0?"selected":""}}>Inactive</option>
                    </select>
                </div>
        
                {{-- Employee Leave Type Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Leave Type Description')}} <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control"  placeholder="Enter  Leave Type Description">{{$model->description}}</textarea>
                </div>
        
                @can('employee_leave_type.update')
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary btn-sm" id="submit">{{_lang('Save')}}<i class="fa ml-2 fa-crosshairs" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2();

    $('#name').keyup(function() {
        var val = $(this).val();
        $('#alias').val(val);
    });
</script>