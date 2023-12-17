<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add New Production Brands')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.production-brands.store')}}" method="post" id="content_form">
            @csrf
                <div class="row">
                    {{-- Production Brands Name --}}
                    <div class="col-md-6 form-group">
                        <label for="name">{{_lang('Production Brands Name')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Production Brands Name" required>
                    </div>
                    {{-- Production owner_name --}}
                    <div class="col-md-6 form-group">
                        <label for="owner_name">{{_lang('Owner Name')}} <span class="text-danger">*</span></label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="Enter Owner Name" required>
                        
                    </div>
                    {{-- Production email --}}
                    <div class="col-md-6 form-group">
                        <label for="email">{{_lang('Email Address')}} <span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" required>
                        
                    </div>
                    {{-- Production phone --}}
                    <div class="col-md-6 form-group">
                        <label for="phone">{{_lang('Phone Number')}} <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone" required>  
                    </div>
                    {{-- Production address --}}
                    <div class="col-md-12 form-group">
                        <label for="address">{{_lang('Address')}}
                        </label>
                        <textarea name="address" class="form-control" id="" placeholder="Enter address"></textarea>
                        
                    </div>
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}   <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>
