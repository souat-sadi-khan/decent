<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Blog Category - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.blog-category.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    {{-- Blog Category Name --}}
                    <div class="col-md-6 form-group">
                        <label for="name">{{_lang('Blog Category Name')}} <span class="text-danger">*</span></label>
                        <input type="text" value="{{$model->name}}" name="name" id="name" class="form-control" placeholder="Enter Blog Category Name" required>
                    </div>

                    {{-- Blog Category Status --}}
                    <div class="col-md-6 form-group">
                        <label for="status">{{_lang('Category Status')}}
                        </label>
                        <select data-placeholder="Category Status" name="status" id="status"
                            class="form-control select">
                            <option {{$model->status == 'Active'?'selected':''}} value="Active">{{_lang('Active')}}</option>
                            <option {{$model->status == 'InActive'?'selected':''}} value="InActive">{{_lang('InActive')}}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Update')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}<i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>        
    </div>
</div>