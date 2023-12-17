@extends('eCommerce.layouts.app')         
	@push('main')
	  <!-- Main of the Page -->
     <main id="mt-main">
				<!-- Mt Contact Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" 
        style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x205'}});">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h1>BLOG</h1>
							</div>
						</div>
					</div>
				</section>
				<!-- Mt Contact Banner of the Page end -->
				<!-- Mt Blog Detail of the Page -->
				<div class="mt-blog-detail fullwidth">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 header wow fadeInUp" data-wow-delay="0.4s">
								<!-- Breadcrumbs of the Page -->
								<nav class="breadcrumbs">
									<ul class="list-unstyled">
										<li><a href="{{ url('/') }} ">Home <i class="fa fa-angle-right"></i></a></li>
										<li><a >Blog</a></li>
									</ul>
								</nav>
								<!-- Breadcrumbs of the Page end -->
								{{-- <ul class="list-unstyled align-right">
									<li>
										Categories <a href="#"><i class="fa fa-bars"></i></a>
									</li>
								</ul> --}}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 wow fadeInUp" data-wow-delay="0.4s">
                <!-- Blog Post of the Page -->
                @foreach ($posts as $model)
								<article class="blog-post detail">
									<div class="img-holder">
										<a href="{{route('post-details',$model->post_slug)}}"><img style="max-height: 350px;" src="{{isset($model->image)?asset('storage/blog/'.$model->image):'http://placehold.it/1200x350'}}" alt="image description"></a>
										{{-- <ul class="list-unstyled comment-nav">
											<li><a href="#"><i class="fa fa-comments"></i>12</a></li>
											<li><a href="#"><i class="fa fa-share-alt"></i>14</a></li>
										</ul> --}}
									</div>
									<time class="time"><strong>{{formatDate2($model->date)}}</strong>{{formatMonth($model->date)}}</time>
									<div class="blog-txt">
										<h2><a style="text-transform: uppercase" href="{{route('post-details',$model->post_slug)}}">{!!$model->title!!}</a></h2>
										<ul class="list-unstyled blog-nav">
											<li> <a ><i class="fa fa-clock-o"></i>{{formatDate1($model->date)}}</a></li>
                    <li> <a href="{{route('category-details',$model->category->category_slug)}}"><i class="fa fa-list"></i>{{$model->category?$model->category->name:''}}</a></li>
										</ul>
										<p>{!!limit($model->details)!!}</p>
										<a href="{{route('post-details',$model->post_slug)}}" class="btn-more">Read More</a>
									</div>
                </article>
				 @endforeach
				 
								<!-- Blog Post of the Page end -->
								<!-- Blog Post of the Page end -->
								<!-- Btn Holder of the Page -->
								<div class="btn-holder">
									@if ($posts->previousPageUrl())
									<a href="{{$posts->previousPageUrl()}}" class="btn-prev"><i class="fa fa-angle-left"></i> PREVIOUS</a>
									@endif
									@if ($posts->nextPageUrl())
										
									<a href="{{$posts->nextPageUrl()}}" class="btn-next">NEXT <i class="fa fa-angle-right"></i></a>
									@endif
									{{-- {{ $posts->render() }} --}}
								</div>
								<!-- Btn Holder of the Page end -->
							</div>
						</div>
					</div>
				</div>
				<!-- Mt Blog Detail of the Page end -->
				</main>
	<!-- footer of the Page -->
@endpush