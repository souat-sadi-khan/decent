@extends('eCommerce.layouts.app')
@push('main')
{{-- {{ dd(Session::get('coupon'))}} --}}
<!-- Main of the Page -->
<main id="mt-main">
    <section class="mt-contact-banner mt-banner-22 wow fadeInUp" data-wow-delay="0.4s"
        style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center">CHECK OUT</h1>
                    <!-- Breadcrumbs of the Page -->
                    <nav class="breadcrumbs">
                        <ul class="list-unstyled">
                            <li><a href="{{url('/')}}">Home <i class="fa fa-angle-right"></i></a></li>
                            <li>Check Out</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumbs of the Page end -->
                </div>
            </div>
        </div>
    </section>
    <!-- Mt Process Section of the Page -->
    <div class="mt-process-sec wow fadeInUp" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Process List of the Page -->
                    <ul class="list-unstyled process-list">
                        <li class="active">
                            <span class="counter">01</span>
                            <strong class="title">Shopping Cart</strong>
                        </li>
                        <li class="active">
                            <span class="counter">02</span>
                            <strong class="title">Check Out</strong>
                        </li>
                        <li>
                            <span class="counter">03</span>
                            <strong class="title">Order Request Complete</strong>
                        </li>
                    </ul>
                    <!-- Process List of the Page end -->
                </div>
            </div>
        </div>
    </div><!-- Mt Process Section of the Page end -->
    <!-- Mt Detail Section of the Page -->

    <form action="{{route('shopping-checkout-store')}}" method="post" id="content_form">
        @csrf
        <section class="mt-detail-sec toppadding-zero wow fadeInUp" data-wow-delay="0.4s">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <h2>BILLING DETAILS</h2>
                        <!-- Bill Detail of the Page -->
                        <div action="#" class="bill-detail">
                            <fieldset>
                                <div class="form-group">
                                    <select name="country" class="form-control">
                                        <option value="1">Bangladesh</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col">
                                        <input name="name" type="text" value="{{$client->name}}" class="form-control"
                                            required placeholder="Name">
                                        <input type="hidden" value="{{$client->id}}" name="client_id">
                                    </div>
                                    <div class="col">
                                        <input name="last_name" type="text" value="{{$client->last_name}}"
                                            class="form-control" required placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="company_name" type="text" value="{{$client->company_name}}"
                                        class="form-control" placeholder="Company Name">
                                </div>
                                <div class="form-group">
                                    <textarea name="address" class="form-control" required
                                        placeholder="Address">{{$client->address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <input name="city" type="text" value="{{$client->city}}" class="form-control"
                                        required placeholder="Town / City">
                                </div>
                                <div class="form-group">
                                    <input name="state" type="text" value="{{$client->state}}" class="form-control"
                                        required placeholder="Thana">
                                </div>
                                <div class="form-group">
                                    <input name="post_code" type="text" value="{{$client->post_code}}"
                                        class="form-control" placeholder="Postcode / Zip">
                                </div>
                                <div class="form-group">
                                    <div class="col">
                                        <input name="email" type="email" value="{{$client->email}}" class="form-control"
                                            required placeholder="Email Address">
                                    </div>
                                    <div class="col">
                                        <input name="mobile" type="tel" value="{{$client->mobile}}" class="form-control"
                                            required placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="checkbox" id="checkbox" type="checkbox"> Ship to a different address?
                                </div>




                                <div id="shipping_area" style="display:none">
                                    <div class="form-group row">
                                        <label class="col-md-3" for="forname">Full Name</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="forname" id="forname"
                                                style="font-size:12px;" placeholder="Enter your Full Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3" for="foremail">Email Address</label>
                                        <div class="col-lg-9">
                                            <input type="email" class="form-control" name="foremail" value=""
                                                id="foremail" style="font-size:12px;" placeholder="Enter your Email">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-lg-3" for="forphone">Phone Number</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="forphone" value=""
                                                id="forphone" style="font-size:12px;" placeholder="Enter your Phone">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-lg-3" for="foraddress">Address</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" name="foraddress" style="font-size:12px;"
                                                id="foraddress" placeholder="Address"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-lg-3" for="forcity">City</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="forcity" id="forcity"
                                                style="font-size:12px;" placeholder="City / District">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="order_note"
                                        placeholder="Order Notes"></textarea>
                                </div>
                            </fieldset>

                            <!-- Bill Detail of the Page end -->
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="holder">
                            <h2>YOUR ORDER</h2>
                            <ul class="list-unstyled block">
                                <li>
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">PRODUCTS (qty)</th>
                                                <th scope="col">Price</th>
                                                <th class="text-right" scope="col">TOTALS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($models as $model)
                                            @php
                                            $product = App\models\Production\Product::with('photo_details',
                                            'variation')->findOrFail($model->attributes->product_id);
                                            @endphp
                                            <tr>
                                                <th scope="row"> {{$model->name}} ({{$model->quantity}})</th>
                                                <th scope="row"> {{$model->price}} </th>
                                                <td class="text-right font-weight-bold">
                                                    {{number_format(($model->price)*($model->quantity), 2)}} </td>
                                                <input type="hidden" name="product_id[]"
                                                    value="{{$model->attributes->product_id}}">
                                                <input type="hidden" name="variation_id[]" value="{{$model->id}}">
                                                <input type="hidden" name="price[]" value="{{$model->price}}">
                                                <input type="hidden" name="quantity[]" value="{{$model->quantity}}">
                                                <input type="hidden" name="total[]"
                                                    value="{{($model->price)*($model->quantity)}}">
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </li>
                                @if (Session::get('coupon'))
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                        <div class="txt pull-right">
                                            <span>{{get_option('currency')}} {{number_format(Cart::getSubTotal(), 2)}}</span>
                                            <input type="hidden" name="sub_total" value="{{Cart::getSubTotal()}}">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">SHIPPING</strong>
                                        <div class="txt pull-right">
                                            <span>Free Shipping</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">COUPON AMOUNT</strong>
                                        <div class="txt pull-right">
                                            <span>{{get_option('currency')}} {{number_format(Session::get('coupon'), 2)}}</span>
                                            <input type="hidden" name="coupon" value="{{Session::get('coupon')}}">
                                        </div>
                                    </div>
                                </li>
                                <li style="border-bottom: none;">
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">ORDER TOTAL</strong>
                                        <div class="txt pull-right">
                                            <span>{{get_option('currency')}} {{Session::get('total') != Cart::getSubTotal() ? Session::get('total') : number_format(Session::get('total') - Session::get('coupon'), 2) }}</span>
                                            <input type="hidden" name="total" value="{{Session::get('total') != Cart::getSubTotal() ? Session::get('total') : Session::get('total') - Session::get('coupon') }}">
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                        <div class="txt pull-right">
                                            <span>{{get_option('currency')}} {{Cart::getSubTotal()}}</span>
                                            <input type="hidden" name="sub_total" value="{{Cart::getSubTotal()}}">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">SHIPPING</strong>
                                        <div class="txt pull-right">
                                            <span>Free Shipping</span>
                                        </div>
                                    </div>
                                </li>
                                <li style="border-bottom: none;">
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">ORDER TOTAL</strong>
                                        <div class="txt pull-right">
                                            <span>{{get_option('currency')}} {{Cart::getTotal()}}</span>
                                            <input type="hidden" name="total" value="{{Cart::getTotal()}}">
                                        </div>
                                    </div>
                                </li>

                                @endif
                            </ul>
                            <h2>PAYMENT METHODS</h2>
                            <!-- Panel Group of the Page -->
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <!-- Panel Panel Default of the Page -->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                CASH ON DELIVERY
                                                <span class="check"><i class="fa fa-check"></i></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                        aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <p>Make your payment directly into our bank account. Please use your order
                                                id as
                                                the payment reference. Your order wont be shippided until the funds have
                                                cleared in our account</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Panel Group of the Page end -->
                        </div>
                        <div class="block-holder">
                            <input type="checkbox" required checked> I’ve read &amp; accept the <a href="#">terms &amp;
                                conditions</a>
                        </div>
                        <button type="submit" class="process-btn">PROCEED TO CHECKOUT <i
                                class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!-- Mt Detail Section of the Page end -->
</main><!-- Main of the Page end here -->
@endpush
@push('scripts')
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('backend/js/parsley.min.js')}}"></script>
<script src="{{ asset('js/eCommerce/checkout.js') }}"></script>
<script>
    _formValidation();

</script>
@endpush
