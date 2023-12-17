<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Designation Information for - ')}} <span class="badge badge-primary">{{$model->name}}  </span> </h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.designation.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Employee Designation Name --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Designation Name')}} <span class="text-danger">*</span> </label>
                    <input autocomplete="off" type="text" name="name" id="name" class="form-control" placeholder="Enter Employee Designation Name" required value="{{$model->name}}">
                </div>
        
                {{-- Category --}}
                <div class="col-md-12 form-group">
                    <label for="employee_category_id">{{_lang('Category')}} <span class="text-danger">*</span> </label>
                    <select data-placeholder="Please Select One" name="employee_category_id" id="employee_category_id" class="form-control select" required>
                        <option value="">Please Select One</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$model->employee_category_id == $category->id?"selected":""}}>
                            {{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                {{-- Top Designation --}}
                <div class="col-md-12 form-group">
                    <label for="top_designation_id">{{_lang('Top Designation')}}</label>
                    <select data-placeholder="Please Select One" name="top_designation_id" id="top_designation_id" class="form-control select" >
                        <option value="">Please Select One</option>
                        @foreach ($designations as $designation)
                        <option value="{{$designation->id}}" {{$model->top_designation_id == $designation->id?"selected":""}}>
                            {{$designation->name}}</option>
                        @endforeach
                    </select>
                </div>
        
                {{-- Designation Description --}}
                <div class="col-md-12 form-group">
                    <label for="description">{{_lang('Description')}} <span class="text-danger">*</span> </label>
                    <textarea name="description" class="form-control" id="description" placeholder="Enter Designation Description">{{$model->description}}</textarea>
        
                </div>
        
                @can('employee-designation.update')
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
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
</script>