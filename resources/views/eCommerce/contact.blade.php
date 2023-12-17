@extends('eCommerce.layouts.app')         
	@push('main')
	 <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt Contact Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x205'}});">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text-center">
                <h1>CONTACT</h1>
                <nav class="breadcrumbs">
                  <ul class="list-unstyled">
                    <li><a href="{{url('/')}}">Home <i class="fa fa-angle-right"></i></a></li>
                    <li><a href="javascript::void(0)">Contact</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </section><!-- Mt Contact Banner of the Page -->
        <!-- Mt Contact Detail of the Page -->
        <section class="mt-contact-detail content-info wow fadeInUp" data-wow-delay="0.4s">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12 col-sm-8">
                <div class="txt-wrap">
                  <h1>{{get_option('institute_name')?get_option('institute_name'):''}}</h1>
                  <p>{{get_option('description')?get_option('description'):''}}</p>
                </div>
                <ul class="list-unstyled contact-txt">
                  <li>
                    <strong>Address</strong>
                    <address>{{get_option('address')?get_option('address'):''}}</address>
                    @if (get_option('address_2') && get_option('address_2') != '')
                        <address>{{ get_option('address_2') }}</address>
                    @endif
                    @if (get_option('address_optional') && get_option('address_optional') != '')
                        <address>{{ get_option('address_optional') }}</address>
                    @endif
                    <address>{{get_option('city') ? get_option('city') : '' }} {{get_option('state') ? get_option('state') : '' }} {{get_option('zip') ? get_option('zip') : '' }} {{get_option('country') ? get_option('country') : '' }}</address>
                  </li>
                  <li>
                    <strong>Phone</strong>
                    <p>{{get_option('phone')?get_option('phone'):''}}</p>
                  </li>
                  <li>
                    <strong>E_mail</strong>
                    <p>{{get_option('email')?get_option('email'):''}}</p>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-sm-4">
                <h2>Have a question?</h2>
                <!-- Contact Form of the Page -->
                <form action="{{route('contactus')}}" class="contact-form" id="myfrom" method="post">
                  @csrf
                  <fieldset>
                    <input type="text" required name="name" class="form-control" placeholder="Name">
                    <input type="email" required name="email" class="form-control" placeholder="E-Mail">
                    <input type="text" name="subject" class="form-control" placeholder="Subject">
                    <textarea class="form-control" required name="descsription" placeholder="Message"></textarea>
                    <button class="btn-type3" type="submit">Send</button>
                  </fieldset>
                </form>
                <!-- Contact Form of the Page end -->
              </div>
            </div>
          </div>
        </section><!-- Mt Contact Detail of the Page end -->
        <!-- Mt Map Holder of the Page -->
        <div class="mt-map-holder wow fadeInUp" data-wow-delay="0.4s" data-lat="52.392363" data-lng="1.480408" data-zoom="8">
          <div class="map-info">
            <h2>Sochan</h2>
            <p>Lorem ipsum dolor sit amet...</p>
          </div>
        </div><!-- Mt Map Holder of the Page end -->
      </main>
	<!-- footer of the Page -->
@endpush
	