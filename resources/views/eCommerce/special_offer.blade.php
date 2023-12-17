@extends('eCommerce.layouts.app')
	@push('main')
		<main id="mt-main">
			<section class="mt-contact-banner style4 wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 text-center">
                            <h1>Special Offer - {{ $offer->name }}</h1>
                            <nav class="breadcrumbs">
                                <ul class="list-unstyled">
                                    <li><a href="{{url('/')}}">Home <i class="fa fa-angle-right"></i></a></li>
                                    <li>Special Offer <i class="fa fa-angle-right"></i></li>
                                </ul>
                            </nav>
						</div>
					</div>
				</div>
			</section>

            <div class="container">
				<div class="row">
					<aside id="sidebar" class="col-xs-12 col-sm-4 col-md-3 wow fadeInLeft" data-wow-delay="0.4s">
						<section class="shop-widget">
							<h2>CATEGORIES</h2>
							<ul class="list-unstyled category-list">
								@foreach ($category as $item)
									<li>
										<a href="{{route('category-product',$item->category_slug)}}">
											<span class="name">{{$item->name}}</span>
										    <span class="num">{{count($item->product)}}</span>
										</a>
									</li>
								@endforeach
							</ul>
					    </section>

						<section class="shop-widget">
							<h2>HOT SALE</h2>
                            @php
                                $hot_sale   = App\models\Production\Product::where('hot_sale_status','1')->orderBy('id','desc')->take(4)->get();
                            @endphp
                            @if(count($hot_sale) > 0)
                                @foreach ($hot_sale as $hot_sale_item)
                                @php
                                    $find_price =  App\models\Production\Variation::where('product_id', $hot_sale_item->id)->get();
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
                                        <a href="{{route('product-details',$hot_sale_item->id)}}">
                                            <img src="{{isset($hot_sale_item->photo) && $hot_sale_item->photo != null ?asset('storage/product/'.$hot_sale_item->photo): asset('img/product.jpg')}}">
                                        </a>
                                    </div>
                                    <div class="text">
                                        <div class="frame">
                                            <strong><a href="{{route('product-details',$hot_sale_item->id)}}">{{$hot_sale_item->name}}</a></strong>
                                            <ul class="mt-stars">
                                                <li class="list-group-item count_rating" data-score={{$hot_sale_item->avarage_retting}}>
                                            </ul>
                                        </div>
                                        <span class="price">৳ {{$per_product_price}} </span>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <p style="margin: 0 0 9.5px;
                                padding: 10px;
                                font-size: 20px;
                                background-color: #ddd;
                                color: red;
                                text-align: center;">Sorry. No Hot Sale Product Found At This Moment.</p>
                            @endif
						</section>
					</aside>

                    <div class="col-xs-12 col-sm-8 col-md-9 wow fadeInRight" data-wow-delay="0.4s">
						@if (count($items) > 0)
							<ul class="mt-productlisthold list-inline">
								@foreach ($items as $item)
                                @php
                                    $product = App\models\Production\Product::where('id', $item->product_id)->firstOrFail();
                                    $variation = App\models\Production\Variation::where('id', $item->variation_id)->firstOrFail();
                                @endphp
								<li>

                                <div class="mt-product1 large">
									<div class="box">
										<div class="b1">
											<div class="b2">
                                                <img src="{{$product->photo && $product->photo != '' ?asset('storage/product/'.$product->photo): asset('img/product.jpg') }}" alt="image description">

                                                <span class="caption">
                                                    <span class="off">
                                                    @if ($item->discount_type == 'Percentages')

                                                    @else

                                                        {{ get_option('currency') }}

                                                    @endif
                                                    {{ $item->discount_amount }}{{ $item->discount_type == 'Percentages' ? '%' : ''}} Off</span>
                                                </span>
                                                <form action="{{route('shopping-cart-add')}}" method="post" id="content_form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$product->id}}">
                                                    <input type="hidden" name="name" value="{{$product->name}}">
                                                    <input type="hidden" name="variation" value="{{ $variation->id }}">
                                                    <input type="hidden" name="price" value="{{ $item->price_with_dis }}" id="product_price">
                                                    <input type="hidden"  name="qty" value="1" id="qty">
                                                    <ul class="links">
                                                        
                                                        <li>
                                                            <a class="submit-shpecial-product" href=""><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
                                                        <li><a href="#popup{{$item->id}}" class="lightbox" tabindex="0"><i class="icomoon icon-eye"></i></a></li>
                                                        
                                                    </ul>
                                                </form>

											</div>
										</div>
									</div>
                                    <div class="txt">

                                        <strong class="title">{{$product->name}} | {{$variation->name}}</strong>
                                        <span class="price">৳<span>{{ number_format($item->price_with_dis, 2) }}</span></span>

                                    </div>
								</div>
							</li>
							@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</main>

	<div class="popup-holder">
	    @foreach ($items as $item)
	        @php
                $product = App\models\Production\Product::where('id', $item->product_id)->firstOrFail();
            @endphp
		    <div id="popup{{$item->id}}" class="lightbox">
			<section class="mt-product-detial">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
						    
							<div class="slider">
								<div class="product-slider">
									<img style="margin-top:20px;" src="{{$product->photo && $product->photo != '' ?asset('storage/product/'.$product->photo): asset('img/product.jpg') }}" alt="image description">
								</div>
							</div>
							<div class="detial-holder">
								<ul class="list-unstyled breadcrumbs">
                                    <li>Products <i class="fa fa-angle-right"> </i></li>
                                    <li>{{ $product->name }}</li>
                                </ul>
								<h2>{{ $product->name }}</h2>
								<div class="text-holder">
									<span class="price">BDT {{ number_format($item->price_with_dis, 2) }} <del>{{ number_format($item->price_without_dis, 2) }}</del></span>
								</div>
								<div class="txt-wrap">
									{!! $product->product_description !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		@endforeach
	</div>
@endpush
@push('scripts')
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('backend/js/parsley.min.js')}}"></script>
{{-- <script src="{{asset('js/eCommerce/offer_product.js')}}"></script> --}}
<script>
    $(document).on('click', '.heart', function() {
        var id = $(this).data('id');
        var ip = '{{getIp()}}';
        var url = $(this).data('url');
        
        $(this).html('<i class="fa fa-heart" aria-hidden="true"></i>');
        
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
            $('#content_form').parsley();

    $('.submit-shpecial-product').click(function() {
        event.preventDefault();

            $('#submit').hide();
            $('#submiting').show();
            $(".ajax_error").remove();
            var submit_url = $('#content_form').attr('action');
            //Start Ajax
            var formData = new FormData($("#content_form")[0]);
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'danger') {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                        $('#cart_total').text(data.bdt + ' ' + data.cart_total);
                        if (data.goto) {
                            setTimeout(function () {
                                window.location.href = data.goto;
                            }, 500);
                        }
                    }
                },
                error: function (data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors;
                    if (errors) {
                        var i = 0;
                        $.each(errors, function (key, value) {
                            const first_item = Object.keys(errors)[i]
                            const message = errors[first_item][0];
                            if ($('#' + first_item).length > 0) {
                                $('#' + first_item).parsley().removeError('required', {
                                    updateClass: true
                                });
                                $('#' + first_item).parsley().addError('required', {
                                    message: value,
                                    updateClass: true
                                });
                            }
                            // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                            toastr.error(value);
                            i++;
                        });
                    } else {
                        toastr.warning(jsonValue.message);
        
                    }
                }
            });
    });
</script>
@endpush