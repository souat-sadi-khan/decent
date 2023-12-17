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
{{-- Product --}}
<div class="mt-product1 mt-paddingbottom20">
    <div class="box">
        <div class="b1">
            <div class="b2">
                <a href="{{route('product-details',$item->product_slug)}}">
                    <img src="{{$item->photo ? asset('storage/product/'.$item->photo) : asset('img/product.jpg') }}" alt="{{isset($item->homePage->tab_slider_image_alt)?$item->homePage->tab_slider_image_alt:''}}">
                </a>
                <span class="caption">
                    {{-- <span class="off">15% Off</span> --}}
                    <span class="new">NEW</span>
                </span>

                <ul class="links">
                    <li><a href="{{route('product-details',$item->product_slug)}}"><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
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
                    {{-- <li><a href="#"><i class="icomoon icon-exchange"></i></a></li> --}}
                </ul>
            </div>
        </div>
    </div>
    <div class="txt">
        <strong class="title">{{$item->name}}</strong>
        <span class="price">৳ <span>{{isset($per_product_price) ? $per_product_price : ''}}</span></span>
    </div>
</div>
