

@extends('eCommerce.layouts.app')
@push('main')
<main id="mt-main">
    <section class="mt-contact-banner mt-banner-22 wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <h1 class="text-center">Wish List</h1>
            <!-- Breadcrumbs of the Page -->
            <nav class="breadcrumbs">
              <ul class="list-unstyled">
                <li><a href="#">Home <i class="fa fa-angle-right"></i></a></li>
                <li>Wish List</li>
              </ul>
            </nav>
            <!-- Breadcrumbs of the Page end -->
          </div>
        </div>
      </div>
    </section>
    <div class="paddingbootom-md hidden-xs"></div>
    <!-- Mt Product Table of the Page -->
    <div class="mt-product-table wow fadeInUp" data-wow-delay="0.4s">
      <div class="container">

          @if (count($products) > 0)

          <div class="row border">
            @foreach ($products as $item)
            @php
              $low_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'DESC')->first();
              $low = $low_price ? $low_price->default_sell_price : 0;

              $high_price = App\models\Production\Variation::where('product_id',$item->id)->orderBy('default_sell_price', 'ASC')->first();
              $high = $high_price ? $high_price->default_sell_price : 0;

            @endphp
          <div class="col-xs-12 col-sm-2">
            <div class="img-holder">
              <img src="{{$item->photo?asset('storage/product/'.$item->photo):'http://placehold.it/275x290'}}" alt="Product Image">

            </div>
          </div>

          <div class="col-xs-12 col-sm-5">
            <strong class="product-name">{{$item->name}}</a></strong>
          </div>

          <div class="col-xs-12 col-sm-2">
            <strong class="product-name">{{get_option('currency') ? get_option('currency') : 'BDT'}}
              @if ($low == $high)
                                            {{$low}}
                                        @else
                                            {{$low .' - '. $high}}
                                        @endif
            </strong>
          </div>

          <div class="col-xs-12 col-sm-2">
            <form action="#" class="coupon-form">
                <a href="{{route('product-details',$item->product_slug)}}"><button type="button" style="margin-top: 15px;">APPLY</button></a>
            </form>
          </div>

          <div class="col-xs-12 col-sm-1">
            <a style="cursor:pointer;" data-id=" {{$item->id}}" class="delete" data-url="{{route('delete_into_wishlist')}}" ><i class="fa fa-close"></i></a>
          </div>

          @endforeach
          </div>

          @else
            <div class="text-center">No Product Found On Your Wishlist</div>
          @endif

      </div>
    </div><!-- Mt Product Table of the Page end -->
    <div class="paddingbootom-md hidden-xs"></div>
  </main><!-- Main of the Page end here -->
<!-- footer of the Page -->
@endpush

@push('scripts')
<script>
$(document).on('click', '.delete', function() {
    var id = $(this).data('id');
    var ip = '{{getIp()}}';
    var url = $(this).data('url');
$(this).html(' <i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
  type: 'GET',
  url: url,
  data: {
      id: id, ip: ip
  },

  success: function (data) {
    if(data.status == 'success') {
        toastr.success(data.message);
    }

    if(data.load) {
      window.location.href = '';
    }
  }
});
})
</script>
@endpush
