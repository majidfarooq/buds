// function generateClId() {
//   var c_id = "";
//   var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
//   for (var i = 0; i < 4; i++) {
//     c_id += possible.charAt(Math.floor(Math.random() * possible.length));
//   }
//   c_id += '-';
//   var possible = "0123456789";
//   for (var i = 0; i < 4; i++) {
//     c_id += possible.charAt(Math.floor(Math.random() * possible.length));
//   }
//   $('#cloud_id').val(c_id);
// }


function googleApiLocation() {
  google.maps.event.addDomListener(window, 'load', function () {
    var places = new google.maps.places.Autocomplete(document.getElementById('billing_address1'));
    google.maps.event.addListener(places, 'place_changed', function () {
      var place = places.getPlace();
      var address = place.formatted_address;
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();
      var latlng = new google.maps.LatLng(latitude, longitude);
      var geocoder = geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            var key1 = Object.keys(results[0].geometry.viewport)[0];
            var key2 = Object.keys(results[0].geometry.viewport)[1];
            console.log(results[0]);
            console.log(key1, key1);
            var lat = ((results[0].geometry.viewport[key1].hi + results[0].geometry.viewport[key1].lo) / 2)
            var long = ((results[0].geometry.viewport[key2].hi + results[0].geometry.viewport[key2].lo) / 2)
            // var lat = 'aaa';
            // var long = 'bbb';
            var billing_coordinates = lat + ',' + long
            // var billing_coordinates = ('a,b');
            console.log(results[0].geometry.viewport);
            var address = results[0].formatted_address;
            var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
            var country = results[0].address_components[results[0].address_components.length - 2].long_name;
            var state = results[0].address_components[results[0].address_components.length - 3].long_name;
            var city = results[0].address_components[results[0].address_components.length - 4].long_name;
            document.getElementById('billing_state').value = state;
            document.getElementById('billing_city').value = city;
            document.getElementById('billing_zip').value = pin;
            document.getElementById('billing_coordinates').value = billing_coordinates;
            document.getElementById('billing_lat').value = lat;
            document.getElementById('billing_long').value = long;
          }
        }
      });
    });
  });
}


function googleApiLocationForbusiness() {
  google.maps.event.addDomListener(window, 'load', function () {
    var places = new google.maps.places.Autocomplete(document.getElementById('delivery_address1'));
    google.maps.event.addListener(places, 'place_changed', function () {
      var place = places.getPlace();
      var address = place.formatted_address;
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();
      var latlng = new google.maps.LatLng(latitude, longitude);
      var geocoder = geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            // console.log(results[0]);
            var key1 = Object.keys(results[0].geometry.viewport)[0];
            var key2 = Object.keys(results[0].geometry.viewport)[1];
            console.log(results[0]);
            console.log(key1, key1);
            var lat = ((results[0].geometry.viewport[key1].hi + results[0].geometry.viewport[key1].lo) / 2)
            var long = ((results[0].geometry.viewport[key2].hi + results[0].geometry.viewport[key2].lo) / 2)
            var delivery_coordinates = lat + ',' + long;
            // var delivery_coordinates = ('a,b');
            var address = results[0].formatted_address;
            var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
            var country = results[0].address_components[results[0].address_components.length - 2].long_name;
            var state = results[0].address_components[results[0].address_components.length - 3].long_name;
            var city = results[0].address_components[results[0].address_components.length - 4].long_name;
            document.getElementById('delivery_state').value = state;
            document.getElementById('delivery_city').value = city;
            document.getElementById('delivery_zip').value = pin;
            document.getElementById('delivery_coordinates').value = delivery_coordinates;
            document.getElementById('delivery_lat').value = lat;
            document.getElementById('delivery_long').value = long;
          }
        }
      });
    });
  });
}

$(function () {
  googleApiLocation();
  googleApiLocationForbusiness();
});
(function ($) {
  $.fn.commaSeparated = function () {
    return this.each(function () {
      var block = $(this), field = block.find('#services');
      field.keyup(function (e) {
        console.log(e);
        if (e.keyCode == 188) {
          var $this = $(this);
          var n = $this.val().split(",");
          var str = n[n.length - 2];
          if (str) $(this).after('<span class="removeName btn offer-btn my-2">' + str + '<input class="d-none" value="' + str + '" name="business_info[services][]"><small>x</small></span>');
          $this.val('');
        }
      });
    });
  };
  $(document).on('click', 'span.removeName small', function () {
    $(this).closest('span').remove();
  });
  $("#services_tags").commaSeparated();
})(jQuery);


$('.phone_field').keyup(function () {
  this.value = this.value
    .match(/\d*/g).join('')
    .match(/(\d{0,3})(\d{0,3})(\d{0,4})/).slice(1).join('-')
    .replace(/-*$/g, '');
});

$("#same_as_customer").on('click', function () {
  if ($(this).is(":checked")) {
    $("#recipient_name").prop("disabled", true);
    $("#recipient_phone").prop("disabled", true);
  } else {
    $("#recipient_name").prop("disabled", false);
    $("#recipient_phone").prop("disabled", false);
  }
});
$("#same_as_billing_address").on('click', function () {
  if ($(this).is(":checked")) {
    $("#delivery_coordinates").prop("disabled", true);
    $("#delivery_address1").prop("disabled", true);
    $("#delivery_address2").prop("disabled", true);
    $("#delivery_city").prop("disabled", true);
    $("#delivery_state").prop("disabled", true);
    $("#delivery_zip").prop("disabled", true);
  } else {
    $("#delivery_coordinates").prop("disabled", false);
    $("#delivery_address1").prop("disabled", false);
    $("#delivery_address2").prop("disabled", false);
    $("#delivery_city").prop("disabled", false);
    $("#delivery_state").prop("disabled", false);
    $("#delivery_zip").prop("disabled", false);
  }
});



$.validator.addMethod("sameAsCustomerChecked", function (val, ele, arg) {
  if ($("#same_as_customer").is(":checked") && ($.trim(val) == '')) { return true; }
  return false;
}, "This field is required if Reciepient is not same as Customer");

$.validator.addMethod("sameAsBillingAddressedChecked", function (val, ele, arg) {
  if ($("#same_as_billing_address").is(":checked") && ($.trim(val) == '')) { return false; }
  return true;
}, "This field is required if delivery address is not same as business address");

$("#registerAdmin").validate({
  rules: {
    "first_name": { required: true },
    "last_name": { required: true },
    "phone": { required: true, minlength: 12 },
    "business_name": { required: true },

    "recipient_name": { sameAsCustomerChecked: true },
    "recipient_phone": { sameAsCustomerChecked: true },

    "billing_address1": { required: true },
    "billing_address2": { required: true },
    "billing_city": { required: true },
    "billing_state": { required: true },
    "billing_zipcode": { required: true, number: true, maxlength: 5 },

    "delivery_address1": { sameAsBillingAddressedChecked: true },
    "delivery_address2": { sameAsBillingAddressedChecked: true },
    "delivery_city": { sameAsBillingAddressedChecked: true },
    "delivery_state": { sameAsBillingAddressedChecked: true },
    "delivery_zipcode": { sameAsBillingAddressedChecked: true },

  },
  messages: {
    "first_name": { required: "this field can not be empty", },
    "phone": { required: "please use this format 000-000-0000", },
    "last_name": { required: "this can not be empty", },
    "billing_zipcode": { required: "this field can not be empty", number: "Please enter a valid billing zipcode." },
    "asigned_to": { required: "this field can not be empty", },
    "image": { required: "this field can not be empty", },
    "password": { required: "Please, enter an password", password: "Password Must contain 6 characters.", },
    "cpassword": { required: "Please, enter an password", confirm_password: "Password Must contain 6 characters.", equalTo: "Please enter the same password as above" }
  },
  submitHandler: function (form) { return true; }
});

