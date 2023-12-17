<!DOCTYPE html>
<html lang="en">
<head>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- set the encoding of your site -->
	<meta charset="utf-8">
	<!-- set the viewport width and initial-scale on mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	@stack('seo_section')
	@if(Request::is('product-details*') || Request::is('post-details*'))
	
	@else
	    <title>Desent Footware | Satt IT</title>
	    @if (isset($seo))
        	<meta name="description" content="{{$seo->meta_description}}">
            <meta name="keywords" content="{{$seo->meta_keyword}}">
        	<meta name="title" content="{{$seo->meta_title}}">
        	<meta name="author" content="{{$seo->meta_author}}">
        @endif
	@endif
	<!-- include the site stylesheet -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset(get_option('favicon')?'storage/logo/'.get_option('favicon'):'favicon.png')}}">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic%7cMontserrat:400,700%7cOxygen:400,300,700' rel='stylesheet' type='text/css'>
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap.css">
  <!-- include the site stylesheet -->
  <link rel="stylesheet" href="{{asset('frontend')}}/css/animate.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="{{asset('frontend')}}/css/icon-fonts.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="{{asset('frontend')}}/css/main.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="{{asset('frontend')}}/css/responsive.css">
	<link href="{{asset('backend/css/toastr.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/parsley.css')}}" rel="stylesheet">
	@stack('css')

	@if (isset($seo))
	{!!$seo->google_analytics!!}
	{!!$seo->bing_analytics!!}
	@endif
</head>
<body>
	<!-- main container of all the page elements -->
	<div id="wrapper">
		<!-- Page Loader -->
    <div id="pre-loader" class="loader-container">
      <div class="loader">
        <img src="{{asset('frontend')}}/images/svg/rings.svg" alt="loader">
      </div>
    </div>
		<!-- W1 start here -->
		<div class="w1">
			<!-- mt header style5 start here -->
			<header class="style5" id="mt-header">
				<!-- mt bottom bar start here -->
					@include('eCommerce.inc.navbar')
				<!-- mt bottom bar end here -->
            </header><!-- mt header style5 end here -->
            <!-- mt search popup start here -->
			<div class="mt-search-popup">
				<div class="mt-holder">
					<a href="#" class="search-close"><span></span><span></span></a>
					<div class="mt-frame">
						<form action="{{ route('search_product') }}" method="GET">
							<fieldset>
								<input autocomplete="off" type="text" name="text" id="search_text" placeholder="Search...">
								{{-- <span class="icon-microphone"></span> --}}
								<button class="icon-magnifier" type="submit"></button>
							</fieldset>
						</form>
					</div>
				</div>
			</div><!-- mt search popup end here -->

            @stack('main')

            <footer id="mt-footer" class="style1 wow fadeInUp" data-wow-delay="0.4s">
				@include('eCommerce.inc.footer')
			</footer><!-- footer of the Page end -->
		</div>
		<!-- W1 end here -->
		<span id="back-top" class="fa fa-arrow-up"></span>
	</div>
	<!-- include jQuery -->
	<script src="{{asset('frontend')}}/js/jquery.js"></script>
	<!-- include jQuery -->
	<script src="{{asset('frontend')}}/js/plugins.js"></script>
	<!-- include jQuery -->
	<script src="{{asset('frontend')}}/js/jquery.main.js"></script>
	<script src="{{asset('backend/js/toastr.min.js')}}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
	<script src="{{asset('frontend')}}/js/main.js"></script>

	@stack('scripts')
	<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		});
        toastr.options = { "preventDuplicates": true,};

        $(document).ready(function() {
            /*
            * For Logout
            */
            $(document).on('click', '#logout', function(e) {
                e.preventDefault();
                $(this).html('Please Wait...');
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'POST',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success(data.message);

                        setTimeout(function() {
                            window.location.href = data.goto;
                        }, 2000);
                    },
                    error: function(data) {
                        var jsonValue = $.parseJSON(data.responseText);
                        const errors = jsonValue.errors
                        var i = 0;
                        $.each(errors, function(key, value) {
                            toastr.success(value);
                            i++;
                        });
                    }
                });
            });
		});
		
		// Email Subscription
		$('#submit_news_letter_email').click(function() {
			$('#submit_news_letter_email').attr('disabled', '1');
			$('#submit_news_letter_email').html('Processing...');
			var news_letter_email = $('#news_letter_email').val();
			if(news_letter_email == '') {
				toastr.error('Please Enter Your Email');

				$('#submit_news_letter_email').removeAttr('disabled');
				$('#submit_news_letter_email').html('SUBSCRIBE');
			} else {
				$.ajax({
					url : '/submit-news-letter-email',
					method : 'POST',
					dataType : 'json',
					data : {news_letter_email : news_letter_email},
					success: function(data){
						if(data.status == 'error') {
							toastr.error(data.message);
						}

						if(data.status == 'warning') {
							toastr.warning(data.message);
						}

						if(data.status == 'success') {
							toastr.success(data.message);
							$('#news_letter_email').val('');
						}

						$('#submit_news_letter_email').removeAttr('disabled');
						$('#submit_news_letter_email').html('SUBSCRIBE');
					}
				});
			}
		});
    </script>
</body>
</html>
