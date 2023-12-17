@extends('eCommerce.layouts.app')
@push('main')
@php
$banner_slide = App\EcommerceOffer::where('size', '765 X 580')->with('product')->get();
@endphp
<main id="mt-main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                {{-- Banner Start --}}
                @if (count($banner_slide) > 0)
                <div class="banner-frame mt-paddingsmzero wow fadeInUp" data-wow-delay="0.4s">
                    <div class="slider-7 mt-paddingbottomsm wow fadeInLeft" data-wow-delay="0.4s">
                        <div class="slider banner-slider">

                            @foreach ($banner_slide as $item)
                            <div class="s-holder">
                                <img src="{{$item->image && $item->image != '' ? asset('storage/offer/'. $item->image) : 'http://placehold.it/765x580'}}"
                                    alt="image description">
                                <div class="s-box">
                                    <strong
                                        class="s-title">{{$item->product->category ? $item->product->category->name : ''}}</strong>
                                    <span class="heading add">{{$item->heading}}</span>
                                    <div class="s-txt">
                                        <p>{{$item->sub_heading}}</p>
                                    </div>
                                    <a href="{{route('offer',$item->slug)}}" class="s-shop">SHOP NOW</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 415 X 225 --}}
                    <div class="banner-box third wow fadeInRight" data-wow-delay="0.4s">
                        @php
                        $banner3 = App\models\eCommerce\SpecialOffer::where('status', 1)->get();
                        @endphp
                        @if (count($banner3) > 0)
                            @foreach ($banner3 as $item)
                                <div class="banner-12 right white wow fadeInUp" data-wow-delay="0.4s">
                                    <img style="height: 275px; width: 415px;" src="{{$item->cover_image && $item->cover_image != '' ? asset('storage/eCommerce/special_offer/'. $item->cover_image) : 'http://placehold.it/765x580'}}" alt="Special Image {{$loop->index + 1}}">
                                    <div class="holder">
                                        <h2><span>{{$item->name}}</span><strong>{{$item->sub_heading}}</strong>
                                        </h2>
                                        <a class="btn-shop" href="{{route('special-offer',$item->offer_slug)}}">
                                            <span>SHOP NOW</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif

                {{-- Banner End --}}
                <!-- F Promo Box style2 of the Page -->
                <aside class="f-promo-box style2 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <!-- F Widget Item of the Page -->
                                <div class="f-widget-item">
                                    <span class="widget-icon"><i class="fa fa-plane"></i></span>
                                    <div class="txt-holder">
                                        <h1 class="f-promo-box-heading">FREE SHIPPING</h1>
                                        <p>Free shipping on all US order</p>
                                    </div>
                                </div>
                                <!-- F Widget Item of the Page end -->
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <!-- F Widget Item of the Page -->
                                <div class="f-widget-item border">
                                    <span class="widget-icon"><i class="fa fa-life-ring"></i></span>
                                    <div class="txt-holder">
                                        <h1 class="f-promo-box-heading">SUPPORT 24/7</h1>
                                        <p>We support 24 hours a day</p>
                                    </div>
                                </div>
                                <!-- F Widget Item of the Page end -->
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <!-- F Widget Item of the Page -->
                                <div class="f-widget-item border">
                                    <span class="widget-icon"><i class="fa fa-dropbox"></i></span>
                                    <div class="txt-holder">
                                        <h1 class="f-promo-box-heading">GIFT CARDS</h1>
                                        <p>Give perfect gift</p>
                                    </div>
                                </div>
                                <!-- F Widget Item of the Page end -->
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <!-- F Widget Item of the Page -->
                                <div class="f-widget-item border">
                                    <span class="widget-icon"><i class="fa fa-money"></i></span>
                                    <div class="txt-holder">
                                        <h1 class="f-promo-box-heading">PAYMENT 100% SECURE</h1>
                                        <p>Payment 100% secure</p>
                                    </div>
                                </div>
                                <!-- F Widget Item of the Page end -->
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Banner Part Start --}}
                <div class="banner-frame nospace wow fadeInUp" data-wow-delay="0.4s">
                    @php
                    $offer_categories = App\models\eCommerce\SpecialCategory::where('status', 1)->get();
                    @endphp
                    @if (count($offer_categories) > 0)
                    @foreach ($offer_categories as $item)
                    <div class="banner-9">
                        <img src="{{$item->cover_image && $item->cover_image != '' ? asset('storage/eCommerce/special_category/'. $item->cover_image) : 'http://placehold.it/765x580'}}"
                            alt="image description">
                        <div class="holder">
                            <h2><span>{{$item->category ? $item->category->name : ''}}</span></h2>
                            <a class="btn-shop" href="{{route('category-offer',$item->category->category_slug)}}">
                                <span>SHOP NOW</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    @endforeach
                    @endif
                </div>

                {{-- Banner Part End --}}

                <div class="mt-producttabs style5 wow fadeInUp" data-wow-delay="0.4s">
                    <!-- producttabs start here -->
                    <ul class="producttabs">
                        <li><a href="#tab1" class="active">FEATURED</a></li>
                        <li><a href="#tab2">LATEST</a></li>
                        <li><a href="#tab3">BEST SELLER</a></li>
                    </ul>
                    <!-- producttabs end here -->
                    <div class="tab-content row">
                        <div id="tab1">
                            <div class="tabs-sliderlg">
                                @if (count($featur_product) > 0)
                                    @foreach ($featur_product as $item)
                                        @php
                                            $find_price =  App\models\Production\Variation::where('product_id', $item->id)->get();
                                            if(count($find_price) > 0) {
                                                $total_product_variation = count($find_price);

                                                $price = 0;
                                                foreach($find_price as $row) {
                                                    $default_price = $row['default_sell_price'];
                                                    $price = $price + $default_price;
                                                }
                                        
                                                $per_product_price = round($price / $total_product_variation) ;
                                        
                                            }
                                        @endphp
                                        <div class="slide">
                                            <div class="mt-product2 large bg-grey">
                                                <div class="box">
                                                    <img alt="{{isset($item->homePage->tab_slider_image_alt)?$item->homePage->tab_slider_image_alt:''}}" src="{{$item->photo ? asset('storage/product/'.$item->photo) : asset('img/product.jpg') }}">
                                                    <ul class="links">
                                                        <li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i></a></li>
                                                        <li>
                                                            <a data-url="{{ route('add_into_wishlist') }}" data-id="{{$item->id}}" class="heart" style="cursor:pointer;">
                                                                @php
                                                                    $check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $item->id)->first();
                                                                @endphp
                                                                @if ($check)
                                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                                @else
                                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                                @endif
                                                            </a>
                                                        </li>
                                                        <li><a href="{{route('product-details',$item->product_slug)}}"><i class="fa fa-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="txt">
                                                    <strong class="title">{{$item->name}}</strong>
                                                    <span class="price">{{ get_option('currency') }}<span>{{isset($per_product_price) ? number_format($per_product_price, 2) : ''}}</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div id="tab2">
                            <div class="tabs-sliderlg">
                            @foreach ($latest_product as $item)
                                @php
                                    $find_price =  App\models\Production\Variation::where('product_id', $item->id)->get();
                                    if(count($find_price) > 0) {
                                        $total_product_variation = count($find_price);

                                        $price = 0;
                                        foreach($find_price as $row) {
                                            $default_price = $row['default_sell_price'];
                                            $price = $price + $default_price;
                                        }
                                
                                        $per_product_price = round($price / $total_product_variation) ;
                                
                                    }
                                @endphp
                                <div class="slide">
                                    <div class="mt-product2 large bg-grey">
                                        <div class="box">
                                            <img alt="{{isset($item->homePage->tab_slider_image_alt)?$item->homePage->tab_slider_image_alt:''}}" src="{{$item->photo ? asset('storage/product/'.$item->photo) : asset('img/product.jpg') }}">
                                            <ul class="links">
                                                <li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i></a></li>
                                                <li>
                                                    <a data-url="{{ route('add_into_wishlist') }}" data-id="{{$item->id}}" class="heart" style="cursor:pointer;">
                                                        @php
                                                            $check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $item->id)->first();
                                                        @endphp
                                                        @if ($check)
                                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                </li>
                                                <li><a href="{{route('product-details',$item->product_slug)}}"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="txt">
                                            <strong class="title">{{$item->name}}</strong>
                                            <span class="price">{{ get_option('currency') }}<span>{{isset($per_product_price) ? number_format($per_product_price, 2) : ''}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <div id="tab3">
                            <div class="tabs-sliderlg">
                            @foreach ($best_sellars as $item)
                                @php
                                    $find_price =  App\models\Production\Variation::where('product_id', $item->id)->get();
                                    if(count($find_price) > 0) {
                                        $total_product_variation = count($find_price);

                                        $price = 0;
                                        foreach($find_price as $row) {
                                            $default_price = $row['default_sell_price'];
                                            $price = $price + $default_price;
                                        }
                                
                                        $per_product_price = round($price / $total_product_variation) ;
                                
                                    }
                                @endphp
                                <div class="slide">
                                    <div class="mt-product2 large bg-grey">
                                        <div class="box">
                                            <img alt="{{isset($item->homePage->tab_slider_image_alt)?$item->homePage->tab_slider_image_alt:''}}" src="{{$item->photo ? asset('storage/product/'.$item->photo) : asset('img/product.jpg') }}">
                                            <ul class="links">
                                                <li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i></a></li>
                                                <li>
                                                    <a data-url="{{ route('add_into_wishlist') }}" data-id="{{$item->id}}" class="heart" style="cursor:pointer;">
                                                        @php
                                                            $check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $item->id)->first();
                                                        @endphp
                                                        @if ($check)
                                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                </li>
                                                <li><a href="{{route('product-details',$item->product_slug)}}"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="txt">
                                            <strong class="title">{{$item->name}}</strong>
                                            <span class="price">{{ get_option('currency') }}<span>{{isset($per_product_price) ? number_format($per_product_price, 2) : ''}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- mt producttabs end here -->

                

                <div class="mt-producttabs style6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="mt-heading2">
                        <h2 class="head">RECENT PRODUCTS</h2>
                        <p>FIND YOUR PERFECT SHOE FROM HERE</p>
                    </div>
                    <div class="tabs-slider row">
                        @if (count($products))
                            @foreach ($products as $product)
                                @php
                                    $price = App\models\Production\Variation::where('product_id', $product->id)->first();
                                @endphp
                                <div class="slide">
                                    <div class="mt-product1">
                                        <div class="box">
                                            <div class="b1">
                                                <div class="b2">



                                                    <a href="{{ route('product-details', $product->product_slug) }}"><img src="{{isset($product->photo) && $product->photo != ''?asset('storage/product/'.$product->photo): asset('img/product.jpg') }}" alt="image description"></a>
                                                    <span class="caption">
                                                        <span class="new">new</span>
                                                    </span>
                                                    <ul class="links">
                                                        <li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
                                                        <li><a data-url="{{ route('add_into_wishlist') }}" data-id="{{$item->id}}" class="heart" style="cursor:pointer;">
                                                            @php
																$check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $item->id)->first();
															@endphp
															@if ($check)
																<i class="fa fa-heart" aria-hidden="true"></i>
															@else
																<i class="fa fa-heart-o" aria-hidden="true"></i>
															@endif
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="txt">

                                        <strong class="title"><a href="{{ route('product-details', $product->product_slug) }}">{{ $product->name }}</a></strong>

                                            <span class="price">{{ get_option('currency') }} <span>{{ $price ? number_format($price->default_sell_price, 2) : 0.00}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>


                {{-- Banner Part Start Here --}}
                <div class="banner-frame wow fadeInUp" data-wow-delay="0.4s">
                    @php
                    $banner = App\EcommerceOffer::where('size', '590 X 250')->with('product')->limit(2)->get();
                    @endphp
                    @if (count($banner) > 0)
                    @foreach ($banner as $item)
                    <div class="banner-15 right">
                        <img src="{{$item->image && $item->image != '' ? asset('storage/offer/'. $item->image) : 'http://placehold.it/590X250'}}"
                            alt="image description">
                        <div class="holder">
                            <h2>{{$item->product->category ? $item->product->category->name : ''}}<strong>{{$item->heading}}</strong>
                            </h2>
                            <a class="btn-shop" href="{{route('offer',$item->slug)}}">
                                <span>SHOP NOW</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    @endforeach

                    @endif
                </div>
                {{-- Banner Part End Here --}}
                <div class="mt-smallproducts mt-nopaddingtopxs wow fadeInUp" data-wow-delay="0.4s">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                            <h3 class="heading">Hot Sale</h3>

                            @if (count($hot_sale))
                            @foreach ($hot_sale as $hot_sale_item)
                            @php
                            $find_price = App\models\Production\Variation::where('product_id',
                            $hot_sale_item->id)->get();
                            if(count($find_price) > 0) {
                            $total_product_variation = count($find_price);
                            $price = 0;
                            foreach($find_price as $row) {
                            $default_price = $row['default_sell_price'];
                            $price = $price + $default_price;
                            }
                            $per_product_price = round($price / $total_product_variation) ;
                            }
                            @endphp
                            <div class="mt-product4 mt-paddingbottom20">
                                <div class="img">
                                    <a href="{{route('product-details',$hot_sale_item->product_slug)}}">
                                        <img
                                            src="{{isset($hot_sale_item->photo) && $hot_sale_item->photo != ''?asset('storage/product/'.$hot_sale_item->photo): asset('img/product.jpg') }}">
                                    </a>
                                </div>
                                <div class="text">
                                    <div class="frame">
                                        <strong><a
                                                href="{{route('product-details',$hot_sale_item->product_slug)}}">{{$hot_sale_item->name}}</a></strong>
                                        <ul class="ratting-area">
                                            <li class="list-group-item count_rating"
                                                data-score={{$hot_sale_item->avarage_retting}}>
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <del class="off">$75,00</del> --}}
                                    <span class="price">{{ get_option('currency') }} {{isset($per_product_price)?$per_product_price:''}}</span>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                            <h3 class="heading">Featured Products</h3>

                            @if (count($footer_featur_product))
                            @foreach ($footer_featur_product as $footer_item)
                            @php
                            $find_price = App\models\Production\Variation::where('product_id', $footer_item->id)->get();
                            if(count($find_price) > 0) {
                            $total_product_variation = count($find_price);
                            $price = 0;
                            foreach($find_price as $row) {
                            $default_price = $row['default_sell_price'];
                            $price = $price + $default_price;
                            }
                            $per_product_price = round($price / $total_product_variation) ;
                            }
                            @endphp
                            <div class="mt-product4 mt-paddingbottom20">
                                <div class="img">
                                    <a href="{{route('product-details',$footer_item->product_slug)}}">
                                        <img
                                            src="{{isset($footer_item->photo) && $footer_item->photo != ''?asset('storage/product/'.$footer_item->photo):  asset('img/product.jpg') }}">
                                    </a>
                                </div>
                                <div class="text">
                                    <div class="frame">
                                        <strong><a
                                                href="{{route('product-details',$footer_item->product_slug)}}">{{$footer_item->name}}</a></strong>
                                        <ul class="ratting-area">
                                            <li class="list-group-item count_rating"
                                                data-score={{$footer_item->avarage_retting}}>
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <del class="off">$75,00</del> --}}
                                    <span class="price">{{ get_option('currency') }}
                                        {{isset($per_product_price)?$per_product_price:''}}</span>
                                </div>
                            </div>
                            @endforeach

                            @endif

                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomxs">
                            <h3 class="heading">Sale Products</h3>
                            @foreach ($general_products as $item)
                            @php
                            $find_price = App\models\Production\Variation::where('product_id', $item->id)->get();
                            if(count($find_price) > 0) {
                            $total_product_variation = count($find_price);
                            $price = 0;
                            foreach($find_price as $row) {
                            $default_price = $row['default_sell_price'];
                            $price = $price + $default_price;
                            }
                            $per_product_price = round($price / $total_product_variation) ;
                            }
                            @endphp
                            <div class="mt-product4 mt-paddingbottom20">
                                <div class="img">
                                    <a href="{{route('product-details',$item->product_slug)}}">
                                        <img
                                            src="{{isset($item->photo) && $item->photo != '' ?asset('storage/product/'.$item->photo): asset('img/product.jpg') }}"></a>
                                </div>
                                <div class="text">
                                    <div class="frame">
                                        <strong><a
                                                href="{{route('product-details',$item->product_slug)}}">{{$item->name}}</a></strong>
                                        <ul class="ratting-area">
                                            <li class="list-group-item count_rating"
                                                data-score={{$item->avarage_retting}}>
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <del class="off">$75,00</del> --}}
                                    <span class="price">{{ get_option('currency') }} {{isset($per_product_price)?$per_product_price:''}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <h3 class="heading">Top Rated Products</h3>
                            <!-- mt product4 start here -->

                            @foreach ($top_rated as $item)

                            @php
                                $price = App\models\Production\Variation::where('product_id', $product->id)->first();
                            @endphp
                            <div class="mt-product4 mt-paddingbottom20">
                                <div class="img">
                                    <a href="{{route('product-details',$item->product_slug)}}">
                                        <img src="{{isset($item->photo) && $item->photo != ''?asset('storage/product/'.$item->photo): asset('img/product.jpg') }}"
                                            alt="Top Rated Products Image">
                                    </a>
                                </div>
                                <div class="text">
                                    <div class="frame">
                                        <strong><a href="{{route('product-details',$item->product_slug)}}">{{$item->name}}</a></strong>
                                        <ul class="ratting-area">
                                            <li class="list-group-item count_rating"
                                                data-score={{$item->avarage_retting}}>
                                            </li>
                                        </ul>
                                    </div>
                                    <span class="price">{{ get_option('currency') }} {{ $price ? number_format($price->default_sell_price, 2) : 0.00}} </span>
                                </div>
                            </div><!-- mt product4 end here -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- footer of the Page -->
@endpush
@push('scripts')
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('frontend/js/jquery.raty.js')}}"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e6f1c98ea2e3519"></script>
<script>
    $('.count_rating').raty({
        score: function () {
            return $(this).attr('data-score');
        }, //default score
        starHalf: '{{asset("frontend/images/star-half.png")}}',
        starOn: '{{asset("frontend/images/star-on.png")}}',
        starOff: '{{asset("frontend/images/star-off.png")}}',
        readOnly: true,
        halfShow: true //read only
    });
    $(document).on('click', '.heart', function () {
        var id = $(this).data('id');
        var ip = '{{getIp()}}';
        var url = $(this).data('url');
        $(this).html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                id: id,
                ip: ip
            },
            beforeSend: function () {
                $(this).html(' <i class="fa fa-spinner fa-spin fa-fw"></i>');
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.message);
                }
                if (data.status == 'warning') {
                    toastr.warning(data.message);
                }
            }
        });
    })

</script>

<script>
    @if(Session::get('error'))
    toastr.warning('{{Session::get("error")}}');
    @endif

</script>
@endpush