<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add New Production Variation Template')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.production-variation.store')}}" method="post" id="content_form">
            @csrf
                <div class="row">
                    {{-- Variation Name --}}
                    <div class="col-md-6 form-group">
                        <label for="name">{{_lang('Variation Name')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Variation Name" required>
                    </div>

                    {{-- Variation Status --}}
                    <div class="col-md-6 form-group">
                        <label for="status">{{_lang('Variation Status')}} <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control select" data-placeholder="Select Status" required >
                            <option value="">{{_lang('Select Status')}}</option>
                            <option selected value="1">{{_lang('Active')}}</option>
                            <option value="0">{{_lang('Inactive')}}</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label for="value">{{_lang('Variation Value')}} <span class="text-danger">*</span></label>
                        <input type="text" name="value[]" id="value" class="form-control" placeholder="Enter Variation Value" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="value">{{_lang('Category')}}</label>
                        <select required name="category_id[]" id="category_id" class="form-control c_select" data-placeholder="Select Category For Size">
                            <option value="">Select Category For Size</option>
                            <option value="all">All Category</option>
                            @php
                                $query = App\models\Production\Category::where('parent_id', 0)->where('status', 1)->get();
                            @endphp
                            @foreach ($query as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="data" class="col-md-12 form-group"></div>
                    <input type="hidden" name="number" id="number" value="0">
                
                    <button data-url="{{route('admin.production-variation.addmore')}}" type="button" class="btn btn-info"  id="add">{{_lang('Add More')}}<i class="icon-arrow-right14 position-right"></i></button> 
                </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<script>

    $('.select').select2();
    // add One More Subcatagory
    $('#add').click(function() {
        var variation = $('#value').val();
        if (variation == '') {
            toastr.warning('Please Select Variation Value First');
        } else {
            var url = $(this).data('url');
            var type = $('#number').val();
            type = parseInt(type);
            row = type + 1;
            $('#number').val(row);
            
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                data: {
                    row: row
                },
                success: function(data) {
                    $('#data').append(data);
                    _componentSelect2Normal();
                    $('.s_select').select2();
                }
            });
        }
    });

    // delete the row
    $("#data").on('click', '.closeAddMore', function() {
        var row_id = $(this).data('id');
        $("." + row_id).fadeOut('slow').remove();
    });
</script>