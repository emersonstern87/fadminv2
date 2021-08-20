@extends('layouts.app2')
@section('content')
<div class="login-box-body">
    <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>
    <form action="{{ url('customer/authenticate') }}" method="post">
        {!! csrf_field() !!}
        <div class="input-group mb-3">
            <input type="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="Email">
        </div>
        <div class="input-group mb-4">
            <input type="password" class="form-control" name="password" placeholder="password">
        </div>
        <div class="form-group">
            <div class="col-sm-8 float-left p-l-0 text-left">
                <div class="switch switch-primary d-inline m-r-10">
                    <input type="checkbox" id="switch-p-1" name="remember" checked="">
                    <label for="switch-p-1" class="cr"></label>
                </div>
                <label>{{ __('Remember me') }}</label>
            </div>
            <div class="col-sm-4 float-left">
                <button type="submit" class="btn btn-primary shadow-2 mb-1">{{ __('Sign In') }}</button>
            </div>
        </div>
        <p class="mb-2 text-muted text-left">{{ __('Forgot your password?') }} <a href="{{ route('login.reset', 'customer') }}">{{ __('Reset') }}</a></p>
        <p class="mb-2 text-muted text-left">{{ __('Don\'t have account?') }} <a href="{{ route('customerRegistration.create') }}">{{ __('Join now') }}</a></p>
    </form>
</div>
@endsection
