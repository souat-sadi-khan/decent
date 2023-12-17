<form action="{{route('admin.id-card-template.store')}}" method="post" id="content_form">
    @csrf
    <div class="row">
        {{-- Template Name --}}
        <div class="col-md-6 form-group">
            <label for="name">{{_lang('Template Name')}} <span class="text-danger">*</span> </label>
            <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Enter Employee Template Name" required>
        </div>

        {{-- Width --}}
        <div class="col-md-6 form-group">
            <label for="width">{{_lang('Width')}} </label>
            <div class="input-group">
                <input data-parsley-errors-container="#width_error" autocomplete="off" type="text" required name="width" placeholder="Width" class="form-control input_number"> 
                <div class="input-group-append">
                    <span class="input-group-text">mm</span>
                </div>
            </div>
            <span id="width_error"></span>
        </div>

        {{-- Height --}}
        <div class="col-md-6 form-group">
            <label for="height">{{_lang('Height')}} </label>
            <div class="input-group">
                <input data-parsley-errors-container="#height_error" autocomplete="off" type="text" required name="height" placeholder="Height" class="form-control input_number"> 
                <div class="input-group-append">
                    <span class="input-group-text">mm</span>
                </div>
            </div>
            <span id="height_error"></span>
        </div>

        {{-- No of Id Cards shown Per Page --}}
        <div class="col-md-6 form-group">
            <label for="show_per_page">{{_lang('No of Id Cards shown Per Page')}} </label>
            <input type="text" name="show_per_page" id="show_per_page" class="form-control input_number" autocomplete="off" placeholder="Enter No of Id Cards shown Per Page" required>
        </div>
        
        <div class="form-group col-md-12" align="right">
            <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>

<script>
    $('.select').select2({  width: '100%' });
</script>