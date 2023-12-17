<div class="card">
    <div class="card-header">
        <h6 class="text-center">
            {{_lang('Edit Offer')}}
        </h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.eCommerce-offer.update', $model->id)}}" method="POST" id="content_form">
            @method('PATCH')
            <div class="row">
                {{-- Select Size --}}
                <div class="col-md-6 form-group">
                    <label for="size">{{_lang('Select Size')}}</label>
                    <select data-parsley-errors-container="#parsley-error-select-size" name="size" id="size" class="form-control select" data-placeholder="Select Size" required>
                        <option value="">{{_lang('Select Size')}}</option>
                        <option {{$model->size == '415 X 225' ? 'selected' : ''}} value="415 X 225">415 X 225</option>
                        <option {{$model->size == '765 X 580' ? 'selected' : ''}} value="765 X 580">765 X 580</option>
                        <option {{$model->size == '400 X 210' ? 'selected' : ''}} value="400 X 210">400 X 210</option>
                        <option {{$model->size == '590 X 250' ? 'selected' : ''}} value="590 X 250">590 X 250</option>
                    </select>
                    <span id="parsley-error-select-size"></span>
                </div>
    
                {{-- Select Product --}}
                <div class="col-md-6 form-group">
                    <label for="product_id">{{_lang('Select Product')}}</label>
                    <select data-url="{{route('admin.eCommerce.eCommerce-offer.check_price')}}" data-parsley-errors-container="#parsley-error-select-product" name="product_id" id="product_id" class="form-control select" data-placeholder="Select Product" required>
                        <option value="">{{_lang('Select Product')}}</option>
                        @foreach ($products as $item)
                            <option {{$model->product_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    <span id="parsley-error-select-product"></span>
                </div>
    
                {{-- Old Price --}}
                <div class="col-md-6 form-group">
                    <label for="old_price">{{_lang('Old Price')}}</label>
                    <input value="{{$model->old_price}}" type="text" name="old_price" id="old_price" class="form-control" readonly required>
                </div>
    
                {{-- New Price --}}
                <div class="col-md-6 form-group">
                    <label for="new_price">{{_lang(' New Price')}}</label>
                    <input value="{{$model->new_price}}" type="text" name="new_price" id="new_price" class="form-control" placeholder="Enter New Price" required>
                </div>
    
                {{-- Banner --}}
                <div class="col-md-12 form-group">
                    <label for="banner">{{_lang('Upload Banner')}} <br> <span id="banner_size" class="text-danger"></span> </label>
                    <input required type="file" name="image" id="image" class="dropify" data-default-file="{{asset('storage/offer/'.$model->image)}}"/>
                    <input type="hidden" name="old_file" value="{{$model->image}} ">
                </div>
    
                {{-- Heading --}}
                <div class="col-md-6 form-group">
                    <label for="heading">{{_lang(' Heading')}}</label>
                    <input value="{{$model->heading}}" type="text" name="heading" id="heading" class="form-control" placeholder="Enter Heading for This Offer" required>
                </div>
    
                {{-- Sub Heaading --}}
                <div class="col-md-6 form-group">
                    <label for="sub_heading">{{_lang('Sub Heaading')}}</label>
                    <input value="{{$model->sub_heading}}" type="text" name="sub_heading" id="sub_heading" class="form-control" placeholder="Enter Sub Heading for This Offer" required>
                </div>
            </div>
    
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Save')}}<i class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    _componentDropFile();_componentSelect2Normal();

    $(function() {
        $('#size').change(function() {
            var val = $(this).val();
            $('#banner_size').html('<b> Alert </b>. Your Banner Size Must Be at <b> ' + val + ' Pixel. </b> Other wise Offer will be broke and that will not be showed beautifully..')
        });

        $('#product_id').change(function() {
            var id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    id: id
                },
                success: function (data) {
                    $('#old_price').val(data);
                }
            });
        });
    });

</script>