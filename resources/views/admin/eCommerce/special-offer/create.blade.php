<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Create New Special Offer</b> <br>
    
    <span class="text-danger">Please Note That, you can not add more then 2 special product at a same time. To add a new Special Offer just delete an older special offer. Than add a new Special Offer. <br> Thank You</span>
</div>

<form action="{{ route('admin.eCommerce.special-offer.store') }}" id="content_form" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Offer Name --}}
    <div class="col-md-12 form-group">
        <label for="name">Offer Name <span class="text-danger">*</span></label>
        <input type="text" autocomplete="off" name="name" id="name" class="form-control" placeholder="Enter Offer Name" required>
    </div>

    {{-- Offer Sub Heading --}}
    <div class="col-md-12 form-group">
        <label for="name">Offer Sub Heading <span class="text-danger">*</span></label>
        <input type="text" autocomplete="off" name="sub_heading" id="sub_heading" class="form-control" placeholder="Enter Offer Name" required>
    </div>

    {{-- Cover Image --}}
    <div class="col-md-12 form-group">
        <label for="cover_image">Cover Image <span class="text-danger">*</span></label>
        <input type="file" name="cover_iamge" id="cover_image" class="form-control dropify" required>
        <span class="text-danger">Please Make Sure The Cover Image Must be (WIDTH x HEIGHT) (415 X 225) pixel size.</span>
    </div>

    {{-- Status --}}
    <div class="col-md-12 form-group">
        <label for="status">Select Status</label>
        <select name="status" id="status" class="form-control select" data-placeholder="Select Status" required>
            <option value="">Select Staus</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    {{-- Select Product --}}
    <div class="col-md-12 form-group">
        <label for="select_product">Select Product</label>
        <select data-url="{{ route('admin.eCommerce.add_to_special_offer_row') }}" name="" id="select_product" class="form-control select add-row" data-placeholder="Select Product for Special Offer" required>
            <option value="">Select Product for Special Offer</option>
            @foreach ($document as $item)
                <option value="{{ $item->product_id }} {{ $item->variation_id }}">{{ $item->pro_name }} - {{ $item->variation }} ({{ $item->sku}} ) </option>
            @endforeach
        </select>
    </div>

    <input type="hidden" id="number" value="0">

    <div class="table-responsive">
        <table class="table special_offer_table table-bordered table-striped">
            <thead class="table-info">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>D. Type</th>
                    <th>D. Amount</th>
                    <th>S. Price</th>
                    <th><i class="fa text-danger fa-trash" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="form-group col-md-12" align="right">
        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</form>

<script>
    $('.select').select2({width:'100%'});
</script>
<script>
    var products = [];
    $(".add-row").change(function(){
        var id = $(this).val();
        var url = $(this).data('url');
        var type = $('#number').val();
        var product_id = $(this).val();
        type = parseInt(type);
        row = type + 1;
        if( products.includes( $(this).val() ) ) {
            toastr.warning('Product is Alreaddy Added');
        } else {
            products.push(product_id);
            $('#number').val(row);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                data: {
                    row: row, product_id:product_id
                },
                success: function(data) {
                    $(".special_offer_table tbody").append(data);
                    toastr.success('Product is added into Cart Successfully');
                }
            });
        }
    });

        // delete the row
    $(document).on('click', '.delete_row', function() {
        var row_id = $(this).data('id');

        $("#table_row_" + row_id).fadeOut('slow').remove();
    });

</script>