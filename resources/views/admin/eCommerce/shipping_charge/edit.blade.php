<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Product Coupons')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.shipping-charge.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    {{-- shipping_area --}}
                    <div class="col-md-6 form-group">
                        <label for="shipping_area">{{_lang('Shipping Area')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="shipping_area" value="{{$model->shipping_area}}" id="shipping_area" class="form-control" placeholder="shipping area" required>
                    </div>
                    {{-- Product shipping_charge--}}
                    <div class="col-md-6 form-group">
                        <label for="shipping_charge">{{_lang('shipping charge')}} <span class="text-danger">*</span> </label>
                        <input type="text" name="shipping_charge" value="{{$model->shipping_charge}}" id="shipping_charge" class="form-control" placeholder="shipping charge" required>
                    </div>
                    {{-- Note For shipping  --}}
                    <div class="col-md-12 form-group">
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