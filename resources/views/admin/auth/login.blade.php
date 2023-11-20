@extends('admin.layouts.auth')

@section('content')
    <link href="{{ asset_url('css/login-4.css', true) }}" rel="stylesheet" type="text/css" />

    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{asset_url('images/bg-2.jpg', true)}});">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="{{ url('/') }}">
                                @if(file_exists(asset_dir('images/' . opt('admin_logo'), 1)))
                                    <img alt="{{ opt('site_title') }}" src="{{ _img(asset_url('images/' . opt('admin_logo'), 1), 300, 75) }}"/>
                                @else
                                    <h3>{{ opt('site_title') }}</h3>
                                @endif
                            </a>
                        </div>
                        <div class="kt-login__signin">
                            {{--<div class="kt-login__head">
                                <h3 class="kt-login__title">Sign In To Admin</h3>
                            </div>--}}
                            <form method="POST" class="kt-form" action="{{ admin_url('login/do_login') }}">
                                @csrf
                                <div class="input-group">
                                    <input name="username" type="text" value="" class="form-control" placeholder="Username" autocomplete="off" autofocus />
                                </div>
                                <div class="input-group">
                                    <input name="password" type="password" value="" class="form-control" placeholder="Password">
                                </div>
                                <div class="row kt-login__extra">
                                    <div class="col">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="remember" value="1"> Remember me
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col kt-align-right">
                                        <a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
                                    </div>
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_signin_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign In</button>
                                </div>
                            </form>
                        </div>
                        <div class="kt-login__signup">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Sign Up</h3>
                                <div class="kt-login__desc">Enter your details to create your account:</div>
                            </div>
                            <form class="kt-form" action="{{ admin_url('register') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Name" name="first_name">
                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="email" placeholder="Email" name="email" autocomplete="off">
                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Username" name="username" autocomplete="off">
                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="password" placeholder="Confirm Password" name="rpassword">
                                </div>
                                <div class="row kt-login__extra">
                                    <div class="col kt-align-left">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                                            <span></span>
                                        </label>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_signup_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
                                    <button id="kt_login_signup_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="kt-login__forgot">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Forgotten Password ?</h3>
                                <div class="kt-login__desc">Enter your email to reset your password:</div>
                            </div>
                            <form class="kt-form" action="{{ admin_url('reset') }}">
                                @csrf
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off" />
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp;
                                    <button id="kt_login_forgot_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset_url('libs/login-general.js', true) }}" type="text/javascript"></script>
@endsection
