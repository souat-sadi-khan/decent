<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-light border-grey-300">
            <h5 class="modal-title"></h5>
            <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <h6>{{_lang('Add New Production Category')}}</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.remort_production_category_post')}}" method="post" class="remort_addClass">
                        @csrf
                        <div class="row">
                            {{-- Production Category Name --}}
                            <div class="col-md-12 form-group">
                                <label for="name">{{_lang('Category Name')}} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Production Category Name" required>
                        </div>
                        {{-- Production Category Description --}}
                        <div class="col-md-12 form-group">
                            <label for="name">{{_lang('Category Description')}}
                            </label>
                            <textarea name="description" class="form-control" id="" placeholder="Enter Production Category Description"></textarea>
                            
                        </div>
                        {{-- Production Category Status --}}
                        <div class="col-md-12 form-group">
                            <label for="name">{{_lang('Category Status')}}
                            </label>
                            <div class="toggle lg">
                                <label>
                                    <input name="status" id="status" type="checkbox" value="1"><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12" align="right">
                            {{-- <input type="hidden" name="type[]" value=" "> --}}
                            <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>