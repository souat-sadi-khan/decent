@extends('eCommerce.layouts.app')         
	@push('main')
	 <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt Contact Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x205'}});">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text-center">
                <h1>privacy policy</h1>
                <nav class="breadcrumbs">
                  <ul class="list-unstyled">
                    <li><a href="index.html">Home <i class="fa fa-angle-right"></i></a></li>
                    <li><a href="#">privacy policy</a></li>
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
              <div class="col-xs-12 col-sm-12">
                @if (isset($model))  
                <h1 class="text-center">{{$model->name}}</h1>
                <p>{!!$model->description!!}</p>
                @endif
                
              </div>
            </div>
          </div>
        </section><!-- Mt Contact Detail of the Page end -->
      </main>
	<!-- footer of the Page -->
@endpush
