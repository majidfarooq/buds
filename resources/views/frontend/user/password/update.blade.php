@extends('frontend.layouts.app')
@section('title') {{'Update Password'}} @endsection
@section('page_title') {{'Update Password'}} @endsection
@section('keywords') {{'Update Password'}} @endsection
@section('description') {{'Update Password'}} @endsection
@section('canonical'){{ Request::url() }}@endsection
@section('style')@endsection

@section('content')
 <div class="container-fluid bg-pink">
    <div class="row">
        <div class="col-sm-12 text-center py-4">
            <h1 class="mb-0 text-capitalize">Update Password</h1>
        </div>
    </div>
 </div>

 <div class="container py-5">
  <div class="row">
   <div class="col-lg-4 col-md-12 mx-auto form-card p-5">
    <form action="{{ route('password.update') }}" id="changePassword" method="POST">
     @csrf
     <input type="hidden" name="userId" value="{{ $user->id ? $user->id : '' }}">
     <input type="hidden" name="rememberToken" value="{{ $user->remember_token ? $user->remember_token : '' }}">
     <div class="col-12 form-group mb-3">
      <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="New Password" type="password">
      @error('password')
      <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
     <div class="col-12 form-group mb-3">
       <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Re-Type New Password" type="password">
      @error('password_confirmation')
      <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
     <div class="col-12 form-group mb-3 text-center">Don't have an account yet? <a class="text-dark" href="{{ route('register') }}">Sign Up</a></div>
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
        $("#changePassword").validate({
            errorClass: "ui-state-error",
            rules: {
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
