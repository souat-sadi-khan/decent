<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add New Employee Category')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-category.store')}}" method="post" id="content_form">
            @csrf
                <div class="row">
                    {{-- Employee Category Name --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Category Name')}} <span class="text-danger">*</span> </label>
                        <input autocomplete="off" type="text" name="name" id="name" class="form-control" placeholder="Enter Employee Category Name" required>
                    </div>
                    {{-- Employee Category Description --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Category Description')}} </label>
                        <textarea name="description" class="form-control" id="" placeholder="Enter Employee Category Description"></textarea>
                    </div>
                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>
