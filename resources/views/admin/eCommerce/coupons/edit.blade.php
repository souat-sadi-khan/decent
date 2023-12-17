<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Product Coupons')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.coupons.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    {{-- discount_type --}}
                    <div class="col-md-6 form-group">
                        <label for="coupons_code">{{_lang('Coupons Code')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="coupons_code" value="{{$model->coupons_code}}" id="coupons_code" class="form-control" placeholder="Coupons Code" required>
                    </div>
                    {{-- Product Coupons Code --}}
                    <div class="col-md-6 form-group">
                        <label for="discount_type">{{_lang('Discount Type')}} <span class="text-danger">*</span> </label>
                        <select data-placeholder="Select One" name="discount_type" id="discount_type" class="form-control select">
                            <option value="">Select One</option>
                            <option {{$model->discount_type=='fixed'?'selected':''}} value="fixed">Fixed</option>
                            <option {{$model->discount_type=='percentage'?'selected':''}} value="percentage">Percentage</option>
                        </select>
                    </div>
                    {{-- Product  Discount  Amount--}}
                    <div class="col-md-6 form-group">
                        <label for="discount_amount">{{_lang('Discount Amount')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="discount_amount" id="discount_amount" value="{{$model->discount_amount}}" class="form-control" placeholder="Discount Amount" required>
                    </div>
                    {{-- Note For coupon --}}
                    <div class="col-md-6 form-group">
                        <label for="note">{{_lang('Note')}}</label>
                        <textarea name="note" class="form-control" id="" placeholder="Note">{{$model->note}}</textarea>
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