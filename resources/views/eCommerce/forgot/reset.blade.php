@extends('eCommerce.layouts.app')
@push('main')

<!-- Main of the Page -->
<main id="mt-main">
    <section class="mt-contact-banner" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1>RESET PASSWORD</h1>
                    <nav class="breadcrumbs">
                        <ul class="list-unstyled">
                            <li><a href="{{url('/')}}">HOME <i class="fa fa-angle-right"></i></a></li>
                            <li>RESET PASSWORD</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Mt Detail Section of the Page -->
    <section class="mt-detail-sec toppadding-zero" style="padding-bottom:20px; padding-top:10px; margin-top:20px">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-push-1">
                    <div class="holder" style="margin: 0;">
                        <div class="mt-side-widget">
                            <header>
                                <h2 style="margin: 0 0 5px;">Reset Your Password</h2>
                                <p>Enter your credentials here</p>
                            </header>
                            <form action="{{ route('password.update') }}" method="post" id="content_form">
                              @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <fieldset>
                                    <input  type="text" placeholder="Enter Email Address" class="input" autofocus name="email" id="email" value="{{ $email ?? '' }}">
                                    <input type="hidden" name="user_type" value="Client">
                                    <input required type="password" placeholder="Password" class="input" name="password" id="password">
                                    <input required type="password" placeholder="Confirm Password" class="input" name="password_confirmation" id="password_confirmation">
                                    <button type="submit" id="submit" class="btn-type1">Reset password</button>
                                    <button style="display: none;" type="button" disabled id="submiting" class="btn-type1">Please Wait ...</button>
                                </fieldset>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mt Detail Section of the Page end -->
    <!-- mt side widget end here -->
    {{-- <div class="container">
        <div class="or-divider" style="padding-bottom:20px;"><span class="txt">or</span></div>
    </div> --}}

</main>
<!-- footer of the Page -->
@endpush
@push('scripts')
<script src="{{asset('backend/js/parsley.min.js')}}"></script>
<script src="{{ asset('js/auth/reset.js') }}"></script>
<script>
    $(function() {
        $('#email').focus();
    })
</script>
@endpush
