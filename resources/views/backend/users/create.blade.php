@extends('backend.layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
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
      {!! Form::open(['route' => 'admin.users.store', 'id' => 'create_customer', 'files' => true]) !!}
    <div class="row">
      <div class="col-lg-6 col-md-12 customer_info form_section">
        <div class="col-lg-12 col-md-12">
        <h2>Customer Info</h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text" required autofocus>
          @error('first_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" required>
          @error('last_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input   placeholder="Phone" class="form-control phone_field @error('phone') is-invalid @enderror" id="phone" name="phone" type="text">
          @error('phone') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Business Name" class="form-control  @error('business_name') is-invalid @enderror" id="business_name" name="business_name" type="text">
          @error('business_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Alternate Phone" class="form-control phone_field @error('phone_alt') is-invalid @enderror" id="phone_alt" name="phone_alt" type="text">
            @error('phone_alt') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email">
            @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
          <div class="col-lg-12 col-md-12 form-group">
              <input  placeholder="Stripe id" class="form-control  @error('stripe_id') is-invalid @enderror" id="stripe_id" name="stripe_id" type="text" >
              @error('stripe_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
          </div>
      </div>
      <div class="col-lg-6 col-md-12 recipient_info form_section">
        <div class="col-lg-12 col-md-12">
        <h2>Recipient Info <span>Same as Customer </span> <input type="checkbox" name="same_as_customer" id="same_as_customer">
        </h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Recipient Name" required class="form-control @error('recipient_name') is-invalid @enderror" id="recipient_name" name="recipient_name" type="text">
          @error('recipient_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Recipient Phone" required  class="form-control phone_field @error('recipient_phone') is-invalid @enderror" id="recipient_phone" name="recipient_phone" type="text">
          @error('recipient_phone') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <textarea  class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
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

            <input type="text" name="address1" id="address-input" class="form-control map-input">
            <input type="hidden" name="latitude" id="address-latitude" value="0" />
            <input type="hidden" name="longitude" id="address-longitude" value="0" />
            <div id="address-map-container" >
                <div id="address-map"></div>
            </div>


          <input type="hidden" name="billing_lat" id="billing_lat">
          <input type="hidden" name="billing_long" id="billing_long">
          <input placeholder="Address 1" required  class="form-control @error('billing_address1') is-invalid @enderror" id="billing_address1" name="billing_address1" type="text">
          @error('billing_address1') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Address 2"  class="form-control @error('billing_address2') is-invalid @enderror" id="billing_address2" name="billing_address2" type="text">
          @error('billing_address2') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="City"  class="form-control @error('billing_city') is-invalid @enderror" id="billing_city" name="billing_city" type="text">
          @error('billing_city') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="State" class="form-control @error('billing_state') is-invalid @enderror" id="billing_state" name="billing_state" type="text">
          @error('billing_state') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input required placeholder="12345" class="form-control @error('billing_zip') is-invalid @enderror" id="billing_zip" name="billing_zip" type="text">
          @error('billing_zip') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

      </div>
      <div class="col-lg-6 col-md-12 delivery_address form_section">
        <div class="col-lg-12 col-md-12">
        <h2>Delivery Address <span>Same as Billing Address</span><input type="checkbox" name="same_as_billing_address" id="same_as_billing_address" >
        </h2>
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input type="hidden" name="delivery_coordinates" id="delivery_coordinates">
          <input type="hidden" name="delivery_lat" id="delivery_lat">
          <input type="hidden" name="delivery_long" id="delivery_long">
          <input  placeholder="Address 1" required  class="form-control @error('delivery_address1') is-invalid @enderror" id="delivery_address1" name="delivery_address1" type="text">
          @error('delivery_address1') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  placeholder="Address 2"  class="form-control @error('delivery_address2') is-invalid @enderror" id="delivery_address2" name="delivery_address2" type="text">
          @error('delivery_address2') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input  required placeholder="City"  class="form-control @error('delivery_city') is-invalid @enderror" id="delivery_city" name="delivery_city" type="text">
          @error('delivery_city') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input placeholder="State" class="form-control @error('delivery_state') is-invalid @enderror" id="delivery_state" name="delivery_state" type="text" required >
          @error('delivery_state') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="col-lg-12 col-md-12 form-group">
          <input required placeholder="zip" class="form-control @error('delivery_zip') is-invalid @enderror" id="delivery_zip" name="delivery_zip" type="text">
          @error('delivery_zip') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
      </div>
    </div>
    <hr>
    <div class="row my-4">
    <div class="col-lg-4 col-md-12 text-end cancel-btn"> <a class="back" href="{{ route('admin.users.index') }}">Cancel</a> </div>
    <div class="col-lg-4 col-md-12 form-group"><input class="btn btn-primary btn-block" id="submit" name="submit" required type="submit" value="Submit"></div>
    </div>
      {!! Form::close() !!}
    </div></div>
  </div>
  @endsection
  @section('script')
  @include('flashy::message')
  <script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG6eAdW_1mCTdPUJSGVLrFB_UPMj0Y4Yg&libraries=places&callback=initialize" async defer></script>
  <script>
      var format = function(num){
          var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
          if(str.indexOf(".") > 0) {
              parts = str.split(".");
              str = parts[0];
          }
          str = str.split("").reverse();
          for(var j = 0, len = str.length; j < len; j++) {
              if(str[j] != ",") {
                  output.push(str[j]);
                  if(i%3 == 0 && j < (len - 1)) {
                      output.push(",");
                  }
                  i++;
              }
          }
          formatted = output.reverse().join("");
          return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
      };
      $(document).ready(function () {
          $(".onlyNumbersInput").on('keyup keydown blur', function (event) {
              $(this).val('$'+format($(this).val().replace(/[^0-9]/g, '')));
          });
      });
      $(document).ready(function(){
          $('#applicationInformation').submit(function(){
              if (!$(this).valid()) return false;
          });
      });

      var date = new Date();
      $(function() {
          $( ".datepicker" ).datepicker({
              dateFormat: "dd-M",
              changeMonth: true,
              minDate:  new Date(date.getFullYear(), 0,1),
              maxDate: new Date(date.getFullYear(), 12,31)
          });
      });
      function initialize() {
          $('#address-input').on('keyup keypress', function(e) {
              var keyCode = e.keyCode || e.which;
              if (keyCode === 13) {
                  e.preventDefault();
                  return false;
              }
          });

          const locationInputs = document.getElementsByClassName("map-input");
          const autocompletes = [];
          const geocoder = new google.maps.Geocoder;

          for (let i = 0; i < locationInputs.length; i++) {

              const input = locationInputs[i];
              const fieldKey = input.id.replace("-input", "");
              const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

              const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
              const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

              const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                  center: {lat: latitude, lng: longitude},
                  zoom: 13
              });
              const marker = new google.maps.Marker({
                  map: map,
                  position: {lat: latitude, lng: longitude},
              });

              marker.setVisible(isEdit);
              const autocomplete = new google.maps.places.Autocomplete(input);
              autocomplete.key = fieldKey;
              autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
          }

          for (let i = 0; i < autocompletes.length; i++) {
              const input = autocompletes[i].input;
              const autocomplete = autocompletes[i].autocomplete;
              const map = autocompletes[i].map;
              const marker = autocompletes[i].marker;

              google.maps.event.addListener(autocomplete, 'place_changed', function () {
                  marker.setVisible(false);
                  const place = autocomplete.getPlace();

                  geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                      if (status === google.maps.GeocoderStatus.OK) {
                          if (results[0])
                          {
                              var city = "";
                              var state = "";
                              var country = "";
                              var zipcode = "";
                              var address_components = results[0].address_components;
                              for (var i = 0; i < address_components.length; i++)
                              {
                                  if (address_components[i].types[0] === "administrative_area_level_1" && address_components[i].types[1] === "political") {
                                      state = address_components[i].short_name;
                                      $('#google_state').val(state)
                                  }
                                  if (address_components[i].types[0] === "locality" && address_components[i].types[1] === "political" ) {
                                      city = address_components[i].long_name;
                                      $('#google_city').val(city)
                                  }
                                  if (address_components[i].types[0] === "postal_code" && zipcode == "") {
                                      zipcode = address_components[i].long_name;
                                      $('#google_zipcode').val(zipcode)
                                  }
                                  if (address_components[i].types[0] === "country") {
                                      country = address_components[i].long_name;
                                  }
                              }
                          }


                          const lat = results[0].geometry.location.lat();
                          const lng = results[0].geometry.location.lng();
                          setLocationCoordinates(autocomplete.key, lat, lng);
                      }
                  });

                  if (!place.geometry) {
                      window.alert("No details available for input: '" + place.name + "'");
                      input.value = "";
                      return;
                  }

                  if (place.geometry.viewport) {
                      map.fitBounds(place.geometry.viewport);
                  } else {
                      map.setCenter(place.geometry.location);
                      map.setZoom(17);
                  }
                  marker.setPosition(place.geometry.location);
                  marker.setVisible(true);

              });
          }
      }
      function setLocationCoordinates(key, lat, lng) {
          const latitudeField = document.getElementById(key + "-" + "latitude");
          const longitudeField = document.getElementById(key + "-" + "longitude");
          latitudeField.value = lat;
          longitudeField.value = lng;
      }
      function openAddressModal() {
          $( ".map_Area" ).toggle('slow');
      }
  </script>

  @endsection
