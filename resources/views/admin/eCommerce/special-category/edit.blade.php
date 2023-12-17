<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Update Special Category {{ $model->category->name }}</b>
</div>
<form action="{{ route('admin.eCommerce.special-category.update', $model->id) }}" id="content_form" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    {{-- Offer Name --}}
    <div class="col-md-12 form-group">
        <label for="name">Category Name <span class="text-danger">*</span></label>
        <select name="category_id" id="category_id" class="form-control select" data-placeholder="Select Category" required>
            <option value="">Select Category</option>
            @foreach ($categories as $item)
                <option {{ $model->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Cover Image --}}
    <div class="col-md-12 form-group">
        <label for="cover_image">Cover Image <span class="text-danger">*</span></label>
        <input type="file" name="cover_image" id="cover_image" class="form-control dropify" data-default-file="{{ asset('storage/eCommerce/special_category/'. $model->cover_image)}}" required>
        <span class="text-danger">Please Make Sure The Cover Image Must be (WIDTH x HEIGHT) (400 X 210) pixel size.</span>
        @if ($model->cover_image != '')
            <input type="hidden" name="oldFile" value="{{ $model->cover_image }}">
        @endif
    </div>

    {{-- Status --}}
    <div class="col-md-12 form-group">
        <label for="status">Select Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-control select" data-placeholder="Select Status" required>
            <option value="">Select Status</option>
            <option {{ $model->status == 1 ? 'selected' : ''}} value="1">Active</option>
            <option {{ $model->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
        </select>
    </div>

    <div class="form-group col-md-12" align="right">
        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</form>

<script>
    $('.select').select2();
</script>