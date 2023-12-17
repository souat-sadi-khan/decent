@extends('eCommerce.layouts.app')
@if ($model != '')
  @push('seo_section')
    <meta name="description" content="{{$model->meta_description}}">
    <meta name="keywords" content="{{$model->meta_keyword}}">
    <meta name="title" content="{{$model->seo_title}}">
  @endpush  
@endif
@push('main')
	  <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt Content Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($model->header_image)?asset('storage/eCommerce/terms/'.$model->header_image):'http://placehold.it/1920x205'}});">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text-center">
                <h1>Terms & Condition</h1>
                <nav class="breadcrumbs">
                  <ul class="list-unstyled">
                    <li><a href="index.html">home <i class="fa fa-angle-right"></i></a></li>
                    <li>Terms & Condition</li>
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
                  <h2>{{ $model != '' ? $model->name : 'Our Terms and Condition'}}</h2>
                  <p>{!! $model != '' ? $model->description : '' !!}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Mt About Section of the Page -->
      </main><!-- Main of the Page end -->
	<!-- footer of the Page -->
@endpush