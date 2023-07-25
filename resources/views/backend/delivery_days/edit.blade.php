@extends('backend.layouts.app')
@section('style')

@endsection
@section('content')
  <div class="row"><div class="col-12"><div class="card border-0"></div></div></div>
  <div class="card shadow shadow mb-4">
  <?php $admin = Auth::guard('admin')->user(); ?>
  @if ($message = \Illuminate\Support\Facades\Session::get('error'))
    <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
  @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
    <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
  @endif
  <div class="card h-100 customer_create_form">
    <div class="card-body">
      <div class="col-lg-12 col-md-12">
    <h1>Create a Customer</h1>
      </div>
    <div class="col-12 p-0">
      {!! Form::open(['route' => ['admin.users.update',$user->slug], 'id' => 'update_customer', 'files' => true]) !!}
    <div class="row">
      <div class="col-lg-6 col-md-12 customer_info form_section">  
        <div class="col-lg-12 col-md-12">
        <h2>Customer Info</h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text"  value="{{(isset($user->first_name)?$user->first_name:'')}}" required autofocus>
          @error('first_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" value="{{(isset($user->last_name)?$user->last_name:'')}}" required>
          @error('last_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input   placeholder="Phone" class="form-control phone_field @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" value="{{(isset($user->phone)?$user->phone:'')}}" required>
          @error('phone') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Business Name" class="form-control  @error('business_name') is-invalid @enderror" id="business_name" name="business_name" type="text" value="{{(isset($user->business_name)?$user->business_name:'')}}" required>
          @error('business_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>        
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Alternate Phone" class="form-control phone_field" id="phone_alt" name="phone_alt" type="text" value="{{(isset($user->phone_alt)?$user->phone_alt:'')}}">
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Email" class="form-control" id="email" name="email" type="email" value="{{(isset($user->email)?$user->email:'')}}">
        </div>
      </div>
      <div class="col-lg-6 col-md-12 recipient_info form_section">
        <div class="col-lg-12 col-md-12">
        <h2>Recipient Info <span>Same as Customer </span> <input type="checkbox" name="same_as_customer" id="same_as_customer" {{($user->recipient_phone == $user->phone)? "checked" : ""}} >
        </h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Recipient Name" required class="form-control @error('recipient_name') is-invalid @enderror" id="recipient_name" name="recipient_name" type="text" value="{{(isset($user->recipient_name)?$user->recipient_name:'')}}">
          @error('recipient_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Recipient Phone" required  class="form-control phone_field @error('recipient_phone') is-invalid @enderror" id="recipient_phone" name="recipient_phone" type="text" value="{{(isset($user->recipient_phone)?$user->recipient_phone:'')}}">
          @error('recipient_phone') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <textarea  class="form-control" id="notes" name="notes" placeholder="Notes">{{(isset($user->notes)?$user->notes:'')}}</textarea>
        </div>
      </div>  
    </div>
    <hr>
    
    <div class="row">
      <div class="col-lg-6 col-md-12 billing_address form_section">  
        <div class="col-lg-12 col-md-12">
        <h2>Billing Address</h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input type="hidden" name="billing_coordinates" id="billing_coordinates">
          <input placeholder="Address 1" required  class="form-control @error('billing_address1') is-invalid @enderror" id="billing_address1" name="billing_address1" type="text" value="{{(isset($user->billing_address1)?$user->billing_address1:'')}}">
          @error('billing_address1') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Address 2"  class="form-control @error('billing_address2') is-invalid @enderror" id="billing_address2" name="billing_address2" type="text" value="{{(isset($user->billing_address2)?$user->billing_address2:'')}}">
          @error('billing_address2') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="City"  class="form-control @error('billing_city') is-invalid @enderror" id="billing_city" name="billing_city" type="text" value="{{(isset($user->billing_city)?$user->billing_city:'')}}">
          @error('billing_city') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="CA" class="form-control @error('billing_state') is-invalid @enderror" id="billing_state" name="billing_state" type="text" value="{{(isset($user->billing_state)?$user->billing_state:'')}}">
          @error('CA') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input required placeholder="billing_zip" class="form-control @error('billing_zip') is-invalid @enderror" id="billing_zip" name="billing_zip" type="text" value="{{(isset($user->billing_zip)?$user->billing_zip:'')}}">
          @error('billing_zip') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
      </div>
      <div class="col-lg-6 col-md-12 delivery_address form_section">  
        <div class="col-lg-12 col-md-12">
        <h2>Delivery Address <span>Same as Billing Address</span><input type="checkbox" name="same_as_billing_address" id="same_as_billing_address"  value="{{(isset($user->name)?$user->name:'')}}">
        </h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input type="hidden" name="delivery_coordinates" id="delivery_coordinates">
          <input  placeholder="Address 1" required  class="form-control @error('delivery_address1') is-invalid @enderror" id="delivery_address1" name="delivery_address1" type="text" value="{{(isset($user->delivery_address1)?$user->delivery_address1:'')}}">
          @error('delivery_address1') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Address 2"  class="form-control @error('delivery_address2') is-invalid @enderror" id="delivery_address2" name="delivery_address2" type="text" value="{{(isset($user->delivery_address2)?$user->delivery_address2:'')}}">
          @error('delivery_address2') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="City"  class="form-control @error('delivery_city') is-invalid @enderror" id="delivery_city" name="delivery_city" type="text" value="{{(isset($user->delivery_city)?$user->delivery_city:'')}}">
          @error('delivery_city') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="CA" class="form-control @error('delivery_state') is-invalid @enderror" id="delivery_state" name="delivery_state" type="text" value="{{(isset($user->delivery_state)?$user->delivery_state:'')}}">
          @error('delivery_state') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input required placeholder="12345" class="form-control @error('delivery_zip') is-invalid @enderror" id="delivery_zip" name="delivery_zip" type="text" value="{{(isset($user->delivery_zip)?$user->delivery_zip:'')}}">
          @error('delivery_zip') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
      </div>
    </div>
    <hr>
    <div class="row my-4">
    <div class="col-lg-4 col-md-12 text-end cancel-btn"> <a class="back" href="#">Cancel</a> </div>
    <div class="col-lg-4 col-md-12 form-group"><input class="btn btn-primary btn-block" id="submit" name="submit" required type="submit" value="Submit"></div>
    </div>
      {!! Form::close() !!}
    </div></div>
  </div>
  @endsection
  @section('script')
  @include('flashy::message')
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&key=AIzaSyDreHlutBDFUYo5I-M6N77YcgdgX-kdZ-0"></script>
  <script src="{{ asset('public/assets/backend/js/customer.js') }}"></script>

  @endsection
