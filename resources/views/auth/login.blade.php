@extends('layouts.auth')
@section('auth')
<div class="login-box">
    <form class="login-form" action="{{ route('admin.login') }}" method="post" id="login">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
        <div class="form-group">
            <label class="control-label">Email</label>
            <input class="form-control" type="text" placeholder="Email" autofocus name="email" id="email">
        </div>
        <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" placeholder="Password" name="password" id="password">
        </div>
        <div class="form-group">
            <div class="utility">
                <div class="animated-checkbox">
                    <label>
                        <input type="checkbox"><span class="label-text">Stay Signed in</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
        </div>
    </form>

</div>

@endsection
@push('scripts')
<script src="{{ asset('js/auth/login.js') }}"></script>
<script src="{{ asset('js/admin/forgot_password.js') }}"></script>
@endpush
