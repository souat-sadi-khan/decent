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
                        <li class="active">
                            <span class="counter">03</span>
                            <strong class="title">Order Request Completed</strong>
                        </li>
                    </ul>
                    <!-- Process List of the Page end -->
                </div>
            </div>

            <div class="row text-center">
                <h6>Dear {{$client->name }}</h6>
                <h3>THANKS</h3>

                <p>We Hope You Enjoy Your Purchase.</p>

                <p>All Of Our Purchase Are Crafted With An Obsassive Attention To Details</p>

                <p>We'd love To Hear Your Thoughts, or See Pictures</p>

                <p>@decentfootwear</p>

                <h3>DECENT FOOTWEAR</h3>

                <p style="text-decoration:underline;"><a style="color: blue;" href="{{ route('invoice', $transaction->reference_no) }}" target="_blank">Print Your Invoice Copy</a></p>
            </div>
        </div>
    </div><!-- Mt Process Section of the Page end -->

    
</main>
@endpush
@push('scripts')
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('backend/js/parsley.min.js')}}"></script>
<script src="{{ asset('js/eCommerce/checkout.js') }}"></script>
<script>
    _formValidation();

</script>
@endpush
