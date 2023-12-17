@extends('eCommerce.layouts.app')

@if ($model != null)
  @push('seo_section')
      <meta name="description" content="{{ isset($model->meta_description) && $model->meta_description != '' ? $model->meta_description:''}}">
      <meta name="keywords" content="{{ isset($model->meta_keyword) && $model->meta_keyword ?$model->meta_keyword:''}}">
      <meta name="title" content="{{ asset($model->seo_title) && $model->seo_title != '' ? $model->seo_title : ''}}">
  @endpush
@endif

	@push('main')
	  <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt Content Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x205'}});">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text-center">
                <h1>WholeSale Badge</h1>
                <nav class="breadcrumbs">
                  <ul class="list-unstyled">
                    <li><a href="{{url('/')}}">home <i class="fa fa-angle-right"></i></a></li>
                    <li>WholeSale</li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <!-- Mt Content Banner of the Page end -->
        <!-- Mt About Section of the Page -->
        <section class="mt-about-sec wow fadeInUp" data-wow-delay="0.4s">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="txt">
                  <h2>{{ isset($model) && $model != null ? $model->header : 'Contact Us for Whole Sale'}}</h2>
                  
                  <p>{!! isset($model) && $model != null ? $model->description : '' !!}</p>
                  <div>
                    @if (isset($model))
                    <img src="{{ asset('storage/catelog/'.$model->catelog) }}" alt="Wholesale Catelog">
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        
      </main>
	<!-- footer of the Page -->
@endpush
