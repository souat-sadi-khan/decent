<link rel="stylesheet" href="https://i-like-robots.github.io/EasyZoom/css/pygments.css" />
<link rel="stylesheet" href="https://i-like-robots.github.io/EasyZoom/css/easyzoom.css" />
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
<section class="mt-product-detial">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="slider">
					<div class="product-slider">
                        <div class="slide">
                            <span class='zoom zoom_image'>
                            <img class="zoom-img" src="{{$model->photo && $model->photo != '' ?asset('storage/product/'.$model->photo): asset('img/product.jpg') }}"
                                alt="image descrption">
                            </span>
                        </div>
					</div><!-- Product Slider of the Page end -->
					
				</div><!-- Slider of the Page end -->
				<div class="detial-holder">
					<ul class="list-unstyled breadcrumbs">
                        <li>Products <i class="fa fa-angle-right"> </i></li>
                        <li>{{ $model->name }}</li>
                    </ul>
					<h2>{{$model->name}}</h2>
					<div class="rank-rating">
						<ul class="list-unstyled rating-list">
							<li><a href="#"><i class="fa fa-star"></i></a></li>
							<li><a href="#"><i class="fa fa-star"></i></a></li>
							<li><a href="#"><i class="fa fa-star"></i></a></li>
							<li><a href="#"><i class="fa fa-star-o"></i></a></li>
						</ul>
						<span class="total-price">Reviews ({{$total_row}})</span>
					</div><!-- Rank Rating of the Page end -->
					<ul class="list-unstyled list">
						
						<li>
                            <a data-url="{{ route('add_into_wishlist') }}" data-id="{{$model->id}}" class="heart" style="cursor:pointer;">
                            @php
                                $check = App\models\eCommerce\Wishlist::where('ip', getIp())->where('product_id', $model->id)->first();
                            @endphp
                            @if ($check)
                                <i class="fa fa-heart" ></i> WISHLISTED
                            @else
                                <i id='icon' class="fa fa-heart-o" ></i>  ADD TO WISHLIST
                            @endif
                           </a>
                        </li>
					</ul>
					<div class="txt-wrap">
						{{$model->short_description}}
					</div>
					<div class="text-holder">
						<span class="price">BDT {{ number_format($price_with_dis, 2) }} <del>{{ number_format($price_without_dis, 2) }}</del></span>
					</div><!-- Product Form of the Page -->
					<form action="#" class="product-form">
						<fieldset>
							<div class="row-val">
								<label for="qty">qty</label>
								<select id="clr">
									<option>1</option>
								</select>
							</div>
							<div class="row-val">
								<button type="submit">ADD TO CART</button>
							</div>
						</fieldset>
					</form><!-- Product Form of the Page end -->
				</div><!-- Detail Holder of the Page end -->
			</div>
		</div>
	</div>
</section>
<script>
    $(document).ready(function(){
        $('.zoom_image').zoom();
    });
</script>