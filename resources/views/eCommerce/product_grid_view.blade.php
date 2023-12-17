@extends('eCommerce.layouts.app')

	@push('main')
	 <!-- mt main start here -->
			<main id="mt-main">
				<!-- Mt Contact Banner of the Page -->
				<section class="mt-contact-banner style4 wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h1>Product's List</h1>
								<!-- Breadcrumbs of the Page -->
								<nav class="breadcrumbs">
									<ul class="list-unstyled">
										<li><a href="{{url('/')}}">Home <i class="fa fa-angle-right"></i></a></li>
										<li><a href="{{route('product')}} ">Products <i class="fa fa-angle-right"></i></a></li>
										<li>Product List</li>
									</ul>
								</nav><!-- Breadcrumbs of the Page end -->
							</div>
						</div>
					</div>
				</section><!-- Mt Contact Banner of the Page end -->
				<div class="container">
					<div class="row">
						<!-- sidebar of the Page start here -->
						<aside id="sidebar" class="col-xs-12 col-sm-4 col-md-3 wow fadeInLeft" data-wow-delay="0.4s">
							<!-- shop-widget filter-widget of the Page start here -->
							<section class="shop-widget">
								<h2>CATEGORIES</h2>
								<!-- category list start here -->
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
										$per_product_price = 0;

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
												<img src="{{isset($hot_sale_item->photo) && $hot_sale_item->photo != null ?asset('storage/product/'.$hot_sale_item->photo): asset('img/product.jpg')}}">
											</a>
										</div>
										<div class="text">
											<div class="frame">
												<strong><a href="{{route('product-details',$hot_sale_item->product_slug)}}">{{$hot_sale_item->name}}</a></strong>
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
							<header class="mt-shoplist-header">
								{{-- <div class="btn-box">
									<ul class="list-inline">
										<li>
											<a href="#" class="drop-link">
												Default Sorting <i aria-hidden="true" class="fa fa-angle-down"></i>
											</a>
											<div class="drop">
												<ul class="list-unstyled">
													<li><a href="#">ASC</a></li>
													<li><a href="#">DSC</a></li>
													<li><a href="#">Price</a></li>
													<li><a href="#">Relevance</a></li>
												</ul>
											</div>
										</li>
										<li><a class="mt-viewswitcher" href="{{route('product')}}"><i class="fa fa-th-large" aria-hidden="true"></i></a></li>
										<li><a class="mt-viewswitcher" href="{{route('product-list')}}"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
									</ul>
								</div><!-- btn-box end here --> --}}
								<!-- mt-textbox start here -->
								{{-- <div class="mt-textbox">
									<p>Showing  <strong>1–9</strong> of  <strong>65</strong> results</p>
									<p>View   <a href="#">9</a> / <a href="#">18</a> / <a href="#">27</a> / <a href="#">All</a></p>
								</div><!-- mt-textbox end here --> --}}
							</header><!-- mt shoplist header end here -->
							<!-- mt productlisthold start here -->
							@if (count($products) > 0)
							<ul class="mt-productlisthold list-inline">

								@foreach ($products as $item)
								@php
									$low_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'DESC')->first();
									$low = $low_price ? $low_price->default_sell_price != null ? $low_price->default_sell_price : 0 : 0;

									$high_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'ASC')->first();
									$high = $high_price ? $high_price->default_sell_price != null ? $high_price->default_sell_price : 0 : 0;

								@endphp
								<li>
									<!-- mt product1 large start here -->
									<div class="mt-product1 large">
										<div class="box">
											<div class="b1">
												<div class="b2">
													<a href="{{route('product-details',$item->product_slug)}}">
														<img src="{{$item->photo && $item->photo != '' ?asset('storage/product/'.$item->photo): asset('img/product.jpg') }}" alt="image description">
													</a>
													
													<ul class="links">
														<li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
														<li><a data-url="{{ route('add_into_wishlist') }}" data-id="{{$item->id}}" class="heart" style="cursor:pointer;" >
															@php
																$check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $item->id)->first();
															@endphp
															@if ($check)
																<i class="fa fa-heart" aria-hidden="true"></i>
															@else
																<i class="fa fa-heart-o" aria-hidden="true"></i>
															@endif

															</a></li>
														{{-- <li><a href="#"><i class="icomoon icon-exchange"></i></a></li> --}}
													</ul>
												</div>
											</div>
										</div>
										<div class="txt">
											<strong class="title"><a href="{{route('product-details',$item->product_slug)}}">{{$item->name}}</a></strong>
											@if ($low == $high)
												<span class="price">{{get_option('currency')}} <span>{{$low}}</span></span>
											@else
												<span class="price">{{get_option('currency')}} <span>{{$low .' - '. $high}}</span></span>
											@endif
										</div>
									</div><!-- mt product1 center end here -->
								</li>
								@endforeach
							</ul><!-- mt productlisthold end here -->
							{{ $products->links('eCommerce.paginate') }}
							@else

								<div id="NoProductFound">No Product Found For This Category</div>

							@endif
						</div>
					</div>
				</div>
			</main><!-- mt main end here -->
	<!-- footer of the Page -->
@endpush
@push('scripts')
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
</script>
@endpush
