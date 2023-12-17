<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Product Coupons')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.slider.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    {{-- Product Id --}}
                    <div class="col-md-6 form-group">
                        <label for="product_id">{{_lang('Product Name')}} <span class="text-danger">*</span> </label>
                        <select name="product_id" id="product_id" data-placeholder="Select One" class="form-control select">
                            <option value="">Select One</option>
                            @foreach ($product as $product_item)
                                <option {{$model->product_id==$product_item->id?'selected':''}} value="{{$product_item->id}}">{{$product_item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Title --}}
                    <div class="col-md-6 form-group">
                        <label for="title">{{_lang('Title')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="title" value="{{$model->title}}" id="title" class="form-control" placeholder="Title" required>
                    </div>
                    
                    {{-- Product  Title Heading --}}
                    <div class="col-md-6 form-group">
                        <label for="title_heading">{{_lang('Title Heading')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="title_heading" value="{{$model->title_heading}}" id="title_heading" class="form-control" placeholder="Title Heading" required>
                    </div>

                    {{-- slider Image --}}
                    <div class="col-md-6 form-group">
                        <label for="slider_image">{{_lang('Slider Image (765x580)')}} <span class="text-danger">*</span> </label>
                        <input type="file" name="slider_image" id="slider_image" class="form-control" required>
                    </div>
                    {{-- Short Description --}}
                    <div class="col-md-12 form-group">
                        <label for="short_description">{{_lang('Short Description')}}</label>
                        <textarea name="short_description" class="form-control" id="" placeholder="short_description">{{$model->short_description}}</textarea>
                    </div>
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Submit')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>        
    </div>
</div>