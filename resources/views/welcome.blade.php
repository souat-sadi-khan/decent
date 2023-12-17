<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ isset($title) ? $title .' | '. get_option('site_title') :  get_option('site_title')}}</title>
        <link rel="icon" href="{{asset('frontend/assets/icons/favicon.png')}}" type="image/png" sizes="16x16">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="BEST PPL OFFERS For Dating Affiliate Program">
        <meta name="keywords" content="BEST PPL OFFERS For Dating Affiliate Program">
        <link href="{{asset('frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.theme.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/ionicons.min.css')}}"> 
        <link href="{{asset('frontend/assets/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />

        <link href="{{asset('frontend/assets/css/select2.min.css')}} " rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('frontend/assets/css/parsley.css')}}">
        <link href="{{asset('backend/css/toastr.min.css')}}" rel="stylesheet">
    </head>

    <body>
        <div class="wrapper">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
                <div class="container container-s">
                    <a data-toggle="tooltip" data-placement="bottom" title="{{URL::to('/')}}" class="navbar-brand" href="#"><img src="{{asset('frontend/assets/icons/logo.png')}}" width="100px;" alt="Website Logo"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right">
                            <li data-toggle="tooltip" data-placement="bottom" title="Home Menu" class="nav-item"><a class="nav-link js-scroll-trigger" href="#main">Home</a></li>
                            <li data-toggle="tooltip" data-placement="bottom" title="About Menu" class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li data-toggle="tooltip" data-placement="bottom" title="About Menu">
                            <li data-toggle="tooltip" data-placement="bottom" title="Services Menu" class="nav-item"><a class="nav-link js-scroll-trigger" href="#services">Services</a></li data-toggle="tooltip" data-placement="bottom" title="Services Menu">
                            <li data-toggle="tooltip" data-placement="bottom" title="Team Menu" class="nav-item"><a class="nav-link js-scroll-trigger" href="#team">Team</a></li data-toggle="tooltip" data-placement="bottom" title="Team Menu">
                            <li data-toggle="tooltip" data-placement="bottom" title="Contact Menu" class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li data-toggle="tooltip" data-placement="bottom" title="Contact Menu">
                            
                            @if(auth()->check())
                                <li data-toggle="tooltip" data-placement="bottom" title="My Account" class="nav-item"><a class="btn-cta nav-link js-scroll-trigger" href="{{route('home')}} ">My Account</a></li data-toggle="tooltip" data-placement="bottom" title="My Account Menu">
                            @else
                                <li data-toggle="tooltip" data-placement="bottom" title="Sign In" class="nav-item"><a class="btn-cta nav-link js-scroll-trigger" href="{{route('login')}} ">Sign In</a></li data-toggle="tooltip" data-placement="bottom" title="Sign In Menu">
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <div id="main" class="main">
                <div class="home">
                    <!-- Hero Section-->
                    <div class="container">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="hero-img wow fadeIn">
                                <img class="img-fluid" src="{{asset('frontend/assets/images/big.png')}}" alt="Home">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="hero-content wow fadeIn">
                                    <h1>MORE MONEY LIKE A PRO WITH PPL OFFER|</h1>
                                    <p>Pay-Per-Lead in 1 Minute Deal yourself a higher payout! Weekly Payment ! No Hold ! Blend in your traffic sources to balance your ratios</p>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Register Now" class="btn-action js-scroll-trigger" href="#signup">Register now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- About Section Start -->
                <div id="about" class="features wow fadeInDown">
                    <div class="container-m">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="features-intro">
                                    <h2>What we offer ?</h2>
                                    <p>
                                        Affiliate marketing is a type of performance-based marketing in which a business rewards one or more affiliates for each visitor or customer brought by the affiliate's own marketing efforts.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                            <img src="{{asset('frontend/assets/icons/a1.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>ADULT DATING OFFER</h3>
                                        <p class="text-justify">Adult dating site to arrange casual hookups and sex with local sexy singles worldwide. Free to join, get a date today and hookup and have free sex with someone local to you. Private, secure and professionally run.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a2.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>HEALTH & BEAUTY OFFER</h3>
                                        <p class="text-justify">Health & Beauty. Perfumes . Cosmetics . Skin & Hair Care. Sort by. Title Category Location Price Added Expiration Displayed Distance.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a3.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>SURVEY OFFER</h3>
                                        <p class="text-justify">Fast Support when you need it as you would expect from the best free paid survey site. At offernation, we do our best to ensure that you have access to the best paid surveys, and free cash offers.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a6.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>INSURANCE OFFER</h3>
                                        <p class="text-justify">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolore mque laudantium</p class="text-justify">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- About Section End -->

                <!-- Services Section Start -->
                <div id="services" class="mt-5 pt-5 wow fadeInDown">
                    <div class="container-m">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="features-intro">
                                    <h2>We Offer Services</h2>
                                    <p>
                                        With the help of your Affiliate Manager, try balancing your different traffic sources to achieve a good volume/quantity ratio to maximize your leads and maintain a good CPA.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                            <img src="{{asset('frontend/assets/icons/a1.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>Pay-Per-Lead in 60 seconds</h3>
                                        <p class="text-justify">In essence, a PPL program is a calculated risk exercise for a sponsor which, when correctly planned and executed, can prove to be a serious win-win arrangement for both parties, sponsor and affiliates.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a2.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>Ask yourself…</h3>
                                        <p class="text-justify">If the answer is no, it’s not good enough for PPL either. People will choose PPL over revshare to have their bankroll grow faster and investment recovered on the shorter term. For the long-term, revshare is often more profitable if you’re ready to allow for months..</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a3.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>Blend in your traffic sources to balance your ratios</h3>
                                        <p class="text-justify">With the help of your Affiliate Manager, try balancing your different traffic sources to achieve a good volume/quantity ratio to maximize your leads and maintain a good CPA.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a6.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>24/7 Help & Support</h3>
                                        <p class="text-justify">We typically respond in 24-72 hours. Please call us for emergencies or urgent issues. Skype : bestpploffers
                                        </p class="text-justify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a6.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>Test your traffic sources.</h3>
                                        <p class="text-justify">BEFORE sending them to PPL offers.Know what they’re worth.Not sure?Then you should:</p class="text-justify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="feature-list">
                                    <div class="card-icon">
                                        <div class="card-img">
                                        <img src="{{asset('frontend/assets/icons/a6.png')}}" width="35" alt="Feature">
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <h3>Track your results with your affiliate manager</h3>
                                        <p class="text-justify">Show them that you’re involved and interested in succeeding, and that you wish to improve your sales. Affiliate managers are the best people to help and give you helpful advice.</p class="text-justify">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service Section End -->

                <!-- Team Section Start -->
                <div id="team" class="yd-reviews">
                    <div class="container">
                        <div class="row text-center">
                            <div class="col-sm-12 col-lg-8 offset-lg-2">
                                <div class="intro wow fadeIn" data-wow-delay="0.1s">
                                    <h1>Meet With Our Team</h1>
                                    <p>We are Very Familiar with all the work. As you see we have a lot of work. Contact with us, we will connect to you very soon. </p>
                                </div>
                            </div>
         
                            <div class="col-sm-12 col-lg-8 offset-lg-2 text-center">
                                <div class="review-cards owl-carousel owl-theme wow fadeInDown" data-wow-delay="0.2s">
                                    <div class="card-single">
                                        <div class="review-text">
                                            <h1>"We have very fair pricing policy that would benefit you and us at the same time.
                                                Choose what price you're willing to pay. Get the free plan & if you need more - pay."
                                            </h1>
                                        </div>
                                        <div class="review-attribution">
                                            <div class="review-img">
                                                <img class="img-fluid rounded-circle" src="{{asset('frontend/assets/icons/review-1.png')}} " alt="Review">
                                            </div>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-ios-star-half"></i>
                                            <h2> Albert Rossi</h2>
                                            <h6>Stack Developer</h6>
                                            <a href="#">Dropboxes Inc</a>
                                        </div>
                                    </div>
                                    <div class="card-single">
                                        <div class="review-text">
                                            <h1>"We have very fair pricing policy that would benefit you and us at the same time.
                                            Choose what price you're willing to pay. Get the free plan & if you need more - pay."
                                            </h1>
                                        </div>
                                        <div class="review-attribution">
                                            <div class="review-img">
                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/assets/icons/review-2.png')}} " alt="Review">
                                            </div>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-ios-star-half"></i>
                                            <h2> Melissa Vanbergh</h2>
                                            <h6>Vice President</h6>
                                            <a href="#">Vestor Corp</a>
                                        </div>
                                    </div>
                                    <div class="card-single">
                                        <div class="review-text">
                                            <h1>"We have very fair pricing policy that would benefit you and us at the same time.
                                            Choose what price you're willing to pay. Get the free plan & if you need more - pay."
                                            </h1>
                                        </div>
                                        <div class="review-attribution">
                                            <div class="review-img">
                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/assets/icons/review-3.png')}}" alt="Review">
                                            </div>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <i class="ion ion-star"></i>
                                            <h2> Joshua Peterson</h2>
                                            <h6>Product Developer</h6>
                                            <a href="#">Betabet Inc</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Team Section Ends -->

                <!-- Contact Section Start -->
                <div id="contact" class="ar-ft-single wow fadeIn pt-5">
                    <div class="container-m text-center">
                        <div class="features-intro">
                            <h2>Customer Support</h2>
                            <p>Thank you for using   ! Please complete the form below, so we can provide quick and efficient service. If this is an urgent matter please contact Customer Suppert</p>
                            <div class="contact wow fadeIn" data-wow-delay="0.2s">
                                <form id="contact_form" class="wow zoomIn" action="{{route('contact_form_submit')}} " method="POST" accept-charset="UTF-8" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input maxlength="40" data-toggle="tooltip" data-placement="bottom" title="Enter Your Name Here" required class="form-control" id="name" type="text" name="name" placeholder="Enter Your Name Here" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input maxlength="40" data-toggle="tooltip" data-placement="bottom" title="Enter Your Mail Address" required class="form-control" id="email_address" type="email" name="email" placeholder="Enter Your Mail Address" autocomplete="off">
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <input maxlength="100" data-toggle="tooltip" data-placement="bottom" title="Enter Your Subject Here" required class="form-control" id="subject" type="text" name="subject" placeholder="Enter Your Subject Here" autocomplete="off">
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <textarea data-toggle="tooltip" data-placement="bottom" title="Enter Your Message Here" required name="message" id="message" class="form-control" cols="30" placeholder="Enter Your Message Here" rows="5"></textarea>
                                        </div>

                                        <div class="col-md-3" align="right">
                                            <input data-toggle="tooltip" data-placement="bottom" title="Click for submit" class="submit-button" type="submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                                <div id="response"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Section Ends -->

                <!-- Footer Section Start -->
                <div class="footer-sm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <a data-toggle="tooltip" data-placement="bottom" title="{{URL::to('/')}}" class="footer-logo" href="#"><img src="{{asset('frontend/assets/icons/logo.png')}} " width="100px;" alt="Website Logo"></a>
                            </div>
                            <div class="col-md-4">
                                <h6>&copy; Team Tek Marks {{date('Y')}} Rights Reserved</h6>
                            </div>
                            <div class="col-md-4">
                                <ul>
                                    <li><a href="#">Facebook</a></li>
                                    <li><a href="#">Twitter</a></li>
                                    <li><a href="#">Linkedin</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Section Ends -->

                <!-- Scroll To Top -->
                <div id="back-top" class="bk-top">
                    <div class="bk-top-txt">
                        <a class="back-to-top js-scroll-trigger" href="#main">top</a>
                    </div>
                </div>
                <!-- Scroll To Top Ends-->
            </div>
        </div>

        <!-- Jquery and Js Plugins -->
        <script type="text/javascript" src="{{asset('frontend/assets/js/jquery-2.1.1.js')}}"></script>
        <script type="text/javascript" src="{{asset('frontend/assets/js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('frontend/assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('frontend/assets/js/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('frontend/assets/js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('frontend/assets/js/custom.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
        <script src="{{asset('frontend/assets/js/parsley.min.js')}}"></script>
        <script src="{{asset('backend/js/toastr.min.js')}}"></script>

        <script>
            $(document).ready(function() {
                $('#contact_form').parsley();
            });
        </script>
    </body>
</html>
