<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add New Page Banner')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.page-banner.store')}}" method="post" id="content_form">
            @csrf
                <div class="row">
                    {{-- Select Banner Page --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Select Banner Page')}} <span class="text-danger">*</span>
                        </label>
                        <select required data-placeholder="Select Banner Page" name="page_name" id="page_name" class="form-control select">
                        <option value="">{{_lang('Select Banner Page')}}</option>
                        <option value="Product">{{_lang('Product Page')}}</option>
                        <option value="Login">{{_lang('Login Page')}}</option>
                        <option value="Register">{{_lang('Register Page')}}</option>
                        <option value="Category">{{_lang('Category Page')}}</option>
                        <option value="Contact">{{_lang('Contact Page')}}</option>
                        <option value="Cart">{{_lang('Cart Page')}}</option>
                        <option value="Wishlist">{{_lang('Wishlist Page')}}</option>
                        <option value="Checkout">{{_lang('Checkout Page')}}</option>
                        <option value="dashboard">{{_lang('Dashboard Page')}}</option>
                        <option value="Welcome">{{_lang('Welcome Page')}}</option>
                        <option value="login">{{_lang('Sing Up and Sing In')}}</option>
                        <option value="blog">{{_lang('Blog Page')}}</option>
                        <option value="Track Order">{{_lang('Track Order Page')}}</option>
                        <option value="Whole Sale">{{_lang('Whole Sale Page')}}</option>
                    </select>
                    </div>

                    {{-- Select Banner Page --}}
                        <div class="col-md-12 form-group">
                            <label for="image">{{_lang('Upload Banner Image')}}
                                <span class="text-danger"  style="display: none;" id="b">(Banner Size: 1920x325)</span>
                                <span class="text-danger" style="display: none;" id="a">(Banner Size: 1920x205)</span>
                            </label>
                            <input required type="file" name="image" id="image" class="dropify"
                            data-default-file=""/>
                        </div>


                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2();
</script>

<script>
    _componentDropFile();
    var _ImageUpload = function() {
    if ($('#imageUpload').length > 0) {
        $('#imageUpload').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
};

_ImageUpload();


$(document).on('change', '#page_name', function () {
    var value = $(this).val();
    if (value == 'Product' || value == 'Category' || value == 'Contact' || value == 'Login' || value == 'Register') {
        $('#a').show();
        $('#b').hide();
    }else if(value == 'Cart' || value == 'Checkout' || value == 'Wishlist'){
        $('#b').show();
        $('#a').hide();
    }

});

  </script>
