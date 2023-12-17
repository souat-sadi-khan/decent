<div class="mt-bottom-bar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                {{-- <div class="mt-logo"><a href="#"><img alt="schon" src="{{asset(get_option('logo')?'storage/logo/'.get_option('logo'):'favicon.png')}}"></a></div> --}}
                <div class="mt-logo"><a href="{{url('/')}}">
                    <img style="width:100px;" alt="Brand Logo" src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/logo'. '/' . get_option('logo')) : asset('frontend/images/mt-logo.png') }}">
                </a></div>
                <span class="tel">{{get_option('phone') ? get_option('phone') : '+880 1703 960157'}} </span>
                <a id='card_check' href="{{route('shopping-cart-show')}}">
                <div class="mt-sh-cart2">
                    <span class="icon-handbag"></span>
                    <span id="cart_total">{{get_option('currency')}} {{\Cart::getTotal()}}</span>
                </div>
                </a>

                <!-- mt nav box start here -->
                <div class="mt-nav-box">
                    <ul class="mt-top-list hidden-sm hidden-xs">
                        <li><a href="{{route('whole-sale')}}">Whole Sale</a></li>
                        <li><a href="{{route('member.track')}}">Track Order</a></li>
                        @if (auth('client')->check())
                            <li><a href="{{ route('member.dashboard') }} ">My Account</a></li>
                            <li><a id="logout" style="cursor:pointer;" data-url='{{ route('admin.logout') }}'>LogOut</a></li>
                        @else
                            <li><a href="{{route('login')}}">Sign In</a></li>
                            <li><a href="{{route('register')}}">Sign Up</a></li>
                        @endif
                        {{-- <li><a href="{{route('shopping-checkout')}}">Checkout</a></li> --}}
                        <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                    </ul>
                    <!-- mt holder start here -->
                    <div class="mt-holder">
                        <!-- navigation start here -->
                        <nav id="nav">
                            <ul>
                                <li><a href="{{url('/')}}">Home</a></li>
                                @php
                                    $fetch_categories = App\models\Production\Category::where('status', 1)->where('parent_id', 0)->orderBy('id', 'desc')->limit(3)->get();
                                @endphp
                                @foreach ($fetch_categories as $cat)
                                <li>
                                    @php
                                        $find_the_sub_cat =  App\models\Production\Category::where('parent_id', $cat->id)->where('status', 1)->orderBy('id', 'desc')->get();
                                    @endphp
                                    <a class="{{ count($find_the_sub_cat) > 0 ? 'drop-link' : ''}}" href="{{  route('category-product', $cat->category_slug) }} ">{{ $cat->name }} <i class="fa fa-angle-down hidden-lg hidden-md" aria-hidden="true"></i></a>

                                    @if (count($find_the_sub_cat) > 0)
                                    <div class="s-drop">
                                        <ul>
                                            @foreach ($find_the_sub_cat as $sub_cat)
                                                <li><a href="{{ route('category-product', $sub_cat->category_slug) }}">{{ $sub_cat->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                </li>
                                @endforeach

                                <li><a href="{{route('product')}}">Product</a></li>
                                <li><a href="{{route('blog')}}">Blog</a></li>
                                <li><a href="{{route('about')}}">About</a></li>
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            </ul>
                        </nav><!-- navigation end here -->

                        <!-- mt icon list start here -->
                        <ul class="mt-icon-list">
                            <li class="hidden-lg hidden-md">
                                <a href="#" class="bar-opener mobile-toggle">
                                    <span class="bar"></span>
                                    <span class="bar small"></span>
                                    <span class="bar"></span>
                                </a>
                            </li>
                            <li><a class="icon-magnifier open-search-box" href="#"></a></li>
                        </ul><!-- mt icon list end here -->
                    </div><!-- mt holder end here -->
                </div><!-- mt nav box end here -->
            </div>
        </div>
    </div>
</div>
