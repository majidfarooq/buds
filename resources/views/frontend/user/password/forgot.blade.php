@extends('frontend.layouts.app')
@section('title') {{'Reset Password'}} @endsection
@section('page_title') {{'Reset Password'}} @endsection
@section('keywords') {{'Reset Password'}} @endsection
@section('description') {{'Reset Password'}} @endsection
@section('canonical'){{ Request::url() }}@endsection
@section('style')@endsection
@section('content')
    <div class="container-fluid bg-pink">
        <div class="row">
            <div class="col-sm-12 text-center py-4">
                <h1 class="mb-0 text-capitalize">Forgot password</h1>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 col-md-12 mx-auto form-card p-5">
                <form class="row g-3" method="POST" action="{{ route('password.email') }}" id="user-password">
                    @csrf
                    <div class="col-12 form-group mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" id="email" name="email" type="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 form-group mb-3 text-center">Already have an account? <a class="text-dark" href="{{ route('login') }}">Sign In</a></div>
                    <div class="col-12 form-group">
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary text-dark bg-white p-3 rounded-0" type="submit">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    @include('flashy::message')
    <script type="text/javascript">
        $('#user-password').validate({
            errorClass: "ui-state-error",
            rules: {
                email: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Please enter your email",
                },
            },
        });
    </script>
@endsection
