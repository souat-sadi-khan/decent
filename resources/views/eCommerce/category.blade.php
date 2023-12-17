@extends('eCommerce.layouts.app')   

	@push('main')
	 <!-- mt main start here -->
			<main id="mt-main">
				<!-- Mt Contact Banner of the Page -->
				<section class="mt-contact-banner style4 wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x205'}});">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h1>CHAIRS</h1>
								<!-- Breadcrumbs of the Page -->
								<nav class="breadcrumbs">
									<ul class="list-unstyled">
										<li><a href="index.html">Home <i class="fa fa-angle-right"></i></a></li>
										<li><a href="product-detail.html">Products <i class="fa fa-angle-right"></i></a></li>
										<li>Chairs</li>
									</ul>
								</nav><!-- Breadcrumbs of the Page end -->
							</div>
						</div>
					</div>
				</section><!-- Mt Contact Banner of the Page end -->
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 wow fadeInRight" data-wow-delay="0.4s">
							<!-- mt shoplist header start here -->
							<header class="mt-shoplist-header">
								<!-- btn-box start here -->
								<div class="btn-box">
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
								</div><!-- btn-box end here -->
								<!-- mt-textbox start here -->
								<div class="mt-textbox">
									<p>Showing  <strong>1–9</strong> of  <strong>65</strong> results</p>
									<p>View   <a href="#">9</a> / <a href="#">18</a> / <a href="#">27</a> / <a href="#">All</a></p>
								</div><!-- mt-textbox end here -->
							</header><!-- mt shoplist header end here -->
							<!-- mt productlisthold start here -->
							<ul class="mt-productlisthold list-inline">

								@foreach ($products as $item)
								@php
									$low_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'DESC')->first();
									$low = $low_price->default_sell_price;

									$high_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'ASC')->first();
									$high = $high_price->default_sell_price;
									
								@endphp
								<li>
									<!-- mt product1 large start here -->
									<div class="mt-product1 large">
										<div class="box">
											<div class="b1">
												<div class="b2">
													<a href="{{route('product-details',$item->id)}}"><img src="{{$item->photo?asset('storage/product/'.$item->photo):'http://placehold.it/275x290'}}" alt="image description"></a>
													{{-- <ul class="mt-stars">
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star-o"></i></li>
													</ul> --}}
													<ul class="links">
														<li><a href=""><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
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
											<strong class="title"><a href="{{route('product-details',$item->id)}}">{{$item->name}}</a></strong>
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
							<!-- mt pagination start here -->
							<nav class="mt-pagination">
								<ul class="list-inline">
									<li><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
								</ul>
							</nav><!-- mt pagination end here -->
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
	