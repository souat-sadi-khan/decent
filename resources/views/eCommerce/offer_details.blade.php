@extends('eCommerce.layouts.app')
@push('css')
    <title>{{ $model->product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <meta property="og:title" content="{{ $model->product->name != '' ? $model->product->name : 'Blog Title' }}">
    <meta property="og:description" content="{{ $model->product->name != '' ? $model->product->name : 'Blog Description' }} ">
    <meta property="og:image" content="{{$model->image  ?asset('storage/product/'.$model->image): asset('img/product.jpg') }}">
    <meta property="og:url" content="{{ route('product-details',$model->slug) }}">
    
    <meta name="twitter:title" content="{{ $model->product->name != '' ? $model->product->name : 'Blog Title' }} ">
    <meta name="twitter:description" content=" {{ $model->product->name != '' ? $model->product->name : 'Blog Description' }} .">
    
    <meta property="twitter:image" content="{{$model->image  ?asset('storage/offer/'.$model->image): asset('img/product.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <style>
        /* styles unrelated to zoom */

        /* these styles are for the demo, but are not required for the plugin */
        .zoom {
            display:inline-block;
            position: relative;
        }

        /* magnifying glass icon */
        .zoom:after {
            content:'';
            display:block;
            width:33px;
            height:33px;
            position:absolute;
            top:0;
            right:0;
            background:url(icon.png);
        }

        .zoom img {
            display: block;
        }

        .zoom img::selection { background-color: transparent; }

    </style>

    @endpush
@push('seo_section')
    <meta name="title" content="{{$product->seo_title}}">
    <meta name="keyword" content="{{$product->keyword}}">
    <meta name="description" content="{{$product->meta_description}}">
@endpush
@push('main')

<main id="mt-main">
    <section class="mt-product-detial wow fadeInUp" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="slider">

                        <!-- Comment List of the Page -->
                        <ul class="list-unstyled comment-list">
                            <li><a href="#"><i class="fa fa-heart"></i>
                                @php
                                    $check = App\models\eCommerce\Wishlist::where('product_id', $product->id)->get();
                                    echo count($check);
                                @endphp
                            </a></li>
                            {{-- <li><a href="#"><i class="fa fa-comments"></i>{}</a></li> --}}
                        </ul>
                        <!-- Comment List of the Page end -->

                        <!-- Product Slider of the Page -->
                        <div class="product-slider">
                            @foreach ($product->photo_details as $item)
                            <div class="slide">
                                 <span class='zoom zoom_image'>
                                <img class="zoom-img" src="{{$item->photo && $item->photo != '' ?asset('storage/product/'.$item->photo): asset('img/product.jpg') }}"
                                     alt="image descrption">
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <!-- Product Slider of the Page end -->

                        <!-- Pagg Slider of the Page -->
                        <ul class="list-unstyled slick-slider pagg-slider">
                            @foreach ($product->photo_details as $item)
                            <li>
                                <div class="img"><img
                                        src="{{$item->photo?asset('storage/product/'.$item->photo):'http://placehold.it/105x105'}}"
                                        alt="image description"></div>
                            </li>
                            @endforeach
                        </ul>
                        <!-- Pagg Slider of the Page end -->
                    </div>
                    <!-- Slider of the Page end -->
                    <!-- Detail Holder of the Page -->
                    <form action="{{route('shopping-cart-add')}}" method="post" id="content_form">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}">
                        <input type="hidden" name="name" value="{{$product->name}}">
                        <div class="detial-holder">

                            <!-- Breadcrumbs of the Page -->
                            <ul class="list-unstyled breadcrumbs">
                                <li>Products <i class="fa fa-angle-right"></i></li>
                                <li>{{ $product->name }}</li>
                            </ul>
                            <!-- Breadcrumbs of the Page end -->

                            <h2 class="text-uppercase">{{$model->heading}}</h2>
                            <p>{{$model->sub_heading}}</p>

                            <!-- Rank Rating of the Page -->
                            <div class="rank-rating">
                                <ul class="ratting-area" style="padding-left: 0px;">
                                    <li class="list-group-item" id="avrage_rating"></li>

                                </ul>
                                <span class="total-price">Reviews ({{$total_row}})</span>
                            </div>
                            <!-- Rank Rating of the Page end -->

                            <ul class="list-unstyled list">
                                <li>
                                    <div class="addthis_inline_share_toolbox"></div>
                                    {{-- <div class="sharethis-inline-share-buttons"></div> --}}
                                </li>
                                {{-- <li><a href="#"><i class="fa fa-exchange"></i>COMPARE</a></li> --}}
                                <li><a data-url="{{ route('add_into_wishlist') }}" data-id="{{$product->id}}" class="heart" style="cursor:pointer;">
                                    @php
                                        $check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $product->id)->first();
                                    @endphp
                                    @if ($check)
                                        <i class="fa fa-heart" aria-hidden="true"></i> WISHLISTED
                                    @else
                                        <i class="fa fa-heart-o" aria-hidden="true"></i> ADD TO WISHLIST
                                    @endif
                                    </a></li>
                            </ul>
                            @php
                                $variation = '';
$variation_name = '';
                            @endphp
                            @foreach ($product->variation as $item)
                                @php
                                    $variation .= $item->id;
                                    $variation_name = $item->name;
                                @endphp
                            @endforeach
                            <div style="text-align: center;
                            font-size: 22px;
                            font-weight: bold;" class="col-md-12">Variation : {{$variation_name}}</div>

                            <div class="txt-wrap">
                                {{$product->short_description}}
                            </div>
                            <div class="text-holder row">
                                <input type="hidden" name="variation" value="{{$variation}}">
                                <input type="hidden" name="price" value="{{$model->new_price}}" id="product_price">
                                <div class="col-md-6"><span class="price" id="price" >৳ <del> {{$model->old_price}}</del> </span></div>
                                <div class="col-md-6"><span class="price" id="price">৳ {{$model->new_price}}</span></div>
                                <div class="col-md-6 text-muted" id="qty"></div>

                            </div>
                            <!-- Product Form of the Page -->

                            <div class="product-form">
                                <fieldset>
                                    <div class="row-val">
                                        <label for="qty">qty</label>
                                        <input type="number" name="qty" value="01" required id="qty" placeholder="00">
                                    </div>
                                    <div class="row-val">
                                        <button type="submit">ADD TO CART</button>
                                    </div>
                                </fieldset>
                            </div>
                            <!-- Product Form of the Page end -->
                        </div>
                    </form>
                    <!-- Detail Holder of the Page end -->
                </div>
            </div>
        </div>
    </section><!-- Mt Product Detial of the Page end -->
    <div class="product-detail-tab wow fadeInUp" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="mt-tabs text-center text-uppercase">
                        <li><a href="#tab1" class="active">DESCRIPTION</a></li>
                        <li><a href="#tab2">INFORMATION</a></li>
                        <li><a href="#tab3">REVIEWS ({{$total_row}})</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1">
                            {!!$product->product_description!!}
                        </div>
                        <div id="tab2">
                            {{$product->information}}
                        </div>
                        <div id="tab3">
                            <div class="product-comment">
                                @foreach ($product_rating as $product_rating_item)
                                <div class="mt-box">
                                    <div class="mt-hold">
                                        <ul class="ratting-area">
                                            <li class="list-group-item count_rating"
                                                data-score={{$product_rating_item->rating}}>

                                            </li>
                                        </ul>
                                        <span class="name">{{$product_rating_item->name}}</span>
                                        <time
                                            datetime="2016-01-01">{{date("h:i F d, Y",strtotime($product_rating_item->created_at))}}</time>
                                    </div>
                                    <p>{{$product_rating_item->comment}}</p>
                                </div>

                                @endforeach
                                <form action="{{route('product-rating')}}" class="" id="content_form2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$model->id}}">
                                    <fieldset>
                                        <h2>Add Comment</h2>
                                        <div class="mt-row">
                                            <label>Rating</label>
                                            <ul class="ratting-area">
                                                <li class="list-group-item" id="prd">

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-row">
                                            <label>Name</label>
                                            <input type="text" name="name" required id="name" class="form-control">
                                        </div>
                                        <div class="mt-row">
                                            <label>E-Mail</label>
                                            <input type="text" name="email" required id="email" class="form-control">
                                        </div>
                                        <div class="mt-row">
                                            <label>Review</label>
                                            <textarea class="form-control" required name="comment"
                                                id="comment"></textarea>
                                        </div>
                                        <button type="submit" class="btn-type4">ADD REVIEW</button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Related product --}}
    <div class="related-products wow fadeInUp" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>RELATED PRODUCTS</h2>
                    <div class="row">
                        <div class="col-xs-12">
                            @php
                                $cat_id = $product->category_id;
                                $related = App\models\Production\Product::where('category_id', $cat_id)->inRandomOrder()->take(5)->get();
                            @endphp
                            @foreach ($related as $item)
                                @include('eCommerce.product')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- related products end here -->
    </div>
</main>
<!-- footer of the Page -->
@endpush
@push('scripts')
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('backend/js/parsley.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/eCommerce/product_details.js') }}"></script>
    <script src="{{asset('frontend/js/jquery.raty.js')}}"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e6f1c98ea2e3519"></script>

    {{--<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>--}}
    <script src='{{asset('frontend/js/jquery.zoom.js')}}'></script>
    <script>
        $(document).ready(function(){
            $('.zoom_image').zoom();

        });
    </script>
<script>
    $('#content_form').parsley();

</script>
<script>
    $(function () {
        $('#prd').raty({
            number: 5,
            starOff: '{{asset("frontend/images/star-off.png")}}',
            starOn: '{{asset("frontend/images/star-on.png")}}',
            width: 300,
            scoreName: "score",
        });
    });

</script>
<script>
    $('#avrage_rating').raty({
        score: '{{$avarage_rating}}', //default score
        starHalf: '{{asset("frontend/images/star-half.png")}}',
        starOn: '{{asset("frontend/images/star-on.png")}}',
        starOff: '{{asset("frontend/images/star-off.png")}}',
        readOnly: true,
        halfShow: true //read only
    });
    _formValidation2();

    $('.count_rating').raty({
        score: function () {
            return $(this).attr('data-score');
        }, //default score
        starOn: '{{asset("frontend/images/star-on.png")}}',
        starOff: '{{asset("frontend/images/star-off.png")}}',
        readOnly: true //read only
    });

	$(document).on('click', '.heart', function() {
		var id = $(this).data('id');
		var ip = '{{getIp()}}';
		var url = $(this).data('url');

		$(this).html('<i class="fa fa-heart" aria-hidden="true"></i> WISHLISTED');

		$.ajax({
            type: 'GET',
            url: url,
            data: {
                id: id, ip: ip
            },
			beforeSend: function() {
                $(this).html(' <i class="fa fa-spinner fa-spin fa-fw"></i>');
            },
            success: function (data) {
                if(data.status == 'success') {
                    toastr.success(data.message);
                }
				if(data.status == 'warning') {
                    toastr.warning(data.message);
                }
            }
        });
	})
</script>
@endpush