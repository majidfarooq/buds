@extends('frontend.layouts.app')
@section('title') {{'Sign Up'}} @endsection
@section('page_title') {{'Sign Up'}} @endsection
@section('keywords') {{'Sign Up'}} @endsection
@section('description') {{'Sign Up'}} @endsection
@section('canonical'){{ Request::url() }}@endsection
@section('style')@endsection

@section('content')
    <div class="container-fluid signup-section">
        <div class="row">
            <div class="col-lg-6 col-md-12 col p-4 px-5 signup-black signup-right min-vh-100 mx-auto">
                <form class="row g-3" method="POST" action="{{ route('register') }}" id="register">
                    @csrf
                    <input type="hidden" name="role_id" value="1">
                    <div class="col-12 form-group text-center my-4">
                        <h2>
                            <span class="create-an text-white">Create an Account</span>
                        </h2>
                    </div>
                    <div class="col-12 form-group mb-3">
                        <label class="phone form-label" for="name">Name </label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name"
                               name="name" type="text">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 form-group mb-3">
                        <label class="phone form-label" for="email">Email </label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email"
                               name="email" type="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 form-group mb-3">
                        <label class="password form-label" for="password">Password</label>
                        <div class="input-group-append">
                            <input class="form-control @error('password') is-invalid @enderror"
                                   placeholder="*************" id="password" name="password" type="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 form-group mb-3">
                        <label class="vpassword form-label" for="password_confirmation">Verify Password</label>
                        <div class="input-group-append">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="*************" id="password_confirmation" name="password_confirmation"
                                   type="password">
                            </span>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 form-group already-account">
                        <div class="already-account-box"></div>
                        <h5>
                            <a href="{{ route('login') }}">Already Have an Account?</a>
                        </h5>
                    </div>
                    <div class="col-12 form-group">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 p-0">
                                <button class="btn btn-primary text-white" type="submit">Sign Up</button>
                            </div>
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
        $("#register").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "Please enter your email",
                },
                password: {
                    required: "Please enter your password",
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Please enter same password",
                },
            },
        });
    </script>
    <script></script>
@endsection
