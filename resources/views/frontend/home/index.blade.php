@extends('frontend.layouts.app')
@section('title') {{'Buds Monsey'}} @endsection
@section('keywords') {{'Buds Monsey'}} @endsection
@section('description') {{'Buds Monsey'}} @endsection
@section('canonical'){{ Request::url() }}@endsection
@section('style')
 <style>
     #mainNav{
         position: relative !important;
         background-color: #0c0c0c !important;
         margin-bottom: 2em !important;
     }
 </style>
@endsection
@section('content')
    <div class="loading" style="display:none;">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
            <div></div>
        </div>
    </div>
    <main>
        <section class="p-5 container-fluid position-relative package-section">
            <!-- Button trigger modal -->

            <img src="{{ asset('public/assets/frontend/images/flower.png') }}" alt="flower" class="flower">
            <div class="row py-md-5">
                <div class="col-lg-4 col-md-12 mx-auto text-center">
                    <h1 class="fw-light">Select a Package</h1>
                    <h5 class="">We've crafted these packages with heart and soul so you get a fresh experience with each single delivery on a budget that suits you. </h5>
                </div>
            </div>
            <div class="row py-md-5 list-package">
                @isset($packages)
                    @foreach($packages as $package)
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4 ">
                            <input type="hidden" id="pkgId" value="{{$package->id}}" />
                            <div class="card p-4 openModal" data-id="{{$package->id}}" style="cursor: pointer">
                        <h3>@currency_format($package->amount)</h3>
                        <div class="flower-inner">
                            @if (isset($package->thumbnail) && !empty($package->thumbnail))
                                <img alt="Admin Photo" id="thumbnail_Image"
                                     class=""
                                     src="{{ asset('public' . \Illuminate\Support\Facades\Storage::url($package->thumbnail)) }}"
                                     alt="amherst">
                            @else
                                <img class="img-profile rounded-circle"
                                     src="{{ asset('public/assets/backend/img/placeholder.jpg') }}" alt="amherst">
                            @endif
                        </div>
                        <h2 class="fw-light">{{ (isset($package->title) ? $package->title : '') }}</h2>
                        <p class="">{{ (isset($package->description) ? $package->description : '') }}.</p>
                    </div>
                </div>
                    @endforeach
                @endisset

            </div>
            <div class="row py-md-5">
                <div class="flower-make col-lg-10 col-md-12 mx-auto bg-white d-flex align-items-center position-relative p-4 border-radius">
                    <div class="custompackage col-lg-3 col-md-12 position-relative">
                        <img src="{{ asset('public/assets/frontend/images/custom-package.png') }}" alt="package" class="bg-package">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <h1 class="fw-light mb-0">Make your own custom packages</h1>
                        <h5 class="">$75.00 and onwards </h5>
                    </div>
                    <div class="col-lg-3 col-md-12 main-call-section">
                        <div class="call-bg border-radius p-2">
                            <a href="tel:+8452748546">
                            <h5 class="fw-light m-0">Call Us</h5>
                            <p class="">+1 (845) 274-8546</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row py-md-5">
                <div class="col-lg-12 col-md-12 p-4 bg-yellow p-2 text-center">
                    <p><strong>Disclaimer:</strong> Images are for illustration purposes only. Different designs and flowers will be delivered every week.
                    </p>
                </div>
            </div>
        </section>
        <section class="p-5 container-fluid position-relative things-section">
            <img src="{{ asset('public/assets/frontend/images/things.png') }}" alt="things" class="things">

            <div class="row">
                <h1 class="text-center mb-5">Thing you need to Know</h1>
                <div class="col-lg-4 col-md-6 col-sm-12 things-card mb-5">
                    <div class="things-icon">
                        <img src="{{ asset('public/assets/frontend/images/box.png') }}" alt="box" class="box">

                    </div>
                    <div class="things-text">
                        <h2> Subscription Idea</h2>
                        <p>Once you have subscribed you will start getting every week or every 2 weeks based on your choice a beautiful bouqs at your doorstep.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 things-card mb-5">
                    <div class="things-icon">
                        <img src="{{ asset('public/assets/frontend/images/box.png') }}" alt="box" class="box">
                    </div>
                    <div class="things-text">
                        <h2>Delivery process</h2>
                        <p>You will get every thursday delivered to your doorstep a beautiful bouqs at your doorstep.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 things-card mb-5">
                    <div class="things-icon">
                        <img src="{{ asset('public/assets/frontend/images/box.png') }}" alt="box" class="box">
                    </div>
                    <div class="things-text">
                        <h2>About Payment</h2>
                        <p>You will automatically get charged every Friday after confirmed delivery.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-lg-2 col-lg-4 col-md-6 col-sm-12 things-card mb-5">
                    <div class="things-icon">
                        <img src="{{ asset('public/assets/frontend/images/box.png') }}" alt="box" class="box">
                    </div>
                    <div class="things-text">
                        <h2>Cancel when your not home
                        </h2>
                        <p>If you ever want to cancel your delivery for a week or more, it can be done by calling or emailing us, please note cancelation deadline is thursday 11:00 Am.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 things-card mb-5">
                    <div class="things-icon">
                        <img src="{{ asset('public/assets/frontend/images/box.png') }}" alt="box" class="box">
                    </div>
                    <div class="things-text">
                        <h2>Yom Tov</h2>
                        <p>Before every yom you will get a calendar with upcoming delivery dates, so you know if you need to cancel or request any changes.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade checkoutModal" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <div class="modal-header border-0">
                    <img src="{{ asset('public/assets/frontend/images/BUDS.png') }}" alt="logo" class="modallogo">
                    <button type="button" class="btn-close alert alert-primary ml-5" data-bs-dismiss="modal" aria-label="Close"> &#9587;</button>
                </div>
                <div class="modal-body py-0">
                    <h1 class="text-center mb-5">Confirmation and Checkout</h1>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 package-selected position-relative">
                            <h3>Package Selected</h3>
                            <div class="offset-lg-6 col-lg-6 col-md-12 mb-4 p-2">
                                <label for="changePackage">Change package</label>
                                <select class="form-control mb-20" id="changePackage" name="package" required>
                                    <option value="">Select</option>
                                    @if($packages)
                                        @foreach($packages as $package)
                                           <option data-packageId="{{$package->id}}" value="{{$package->slug}}">{{$package->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div id="getselectPackage" class="d-flex gap-4">
                                <div class="flower-img-main" id="packageImg">
                                    <img src="{{ asset('public/assets/frontend/images/modal-img.png') }}" alt="flower" class="flower-logo">
                                </div>
                                <div class="flower-img">
                                    <div class="d-flex justify-content-between">
                                        <div id="packageTitle">
                                            <h5>Affordable</h5>
                                        </div>
                                        <div id="packageAmount">
                                        <h5>$36.99</h5>
                                        </div>
                                    </div>
                                    <div id="packageDescription">
                                        <p>Standard Bouquet, including a blend of hydrangeas and supplementary seasonal flowers. All wrapped up with buds artistic design.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 p-4 bg-yellow p-2 my-3">
                                <h5 class="m-0">Disclaimer:</h5>
                                <p> Images are for illustration purposes only. Different designs and flowers will be delivered every week.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 form-modal">
                            <div class="row">
                                <form id="signUpForm" action="" class="col-lg-9 col-md-12">
                                    <div class="step step_1 first-screen step-show" id="firstStep">
                                        <div class="card-box mb-3 d-flex">
                                            <input type="radio" class="btn-check delivery_type" value="weekly" name="type" id="Weekly">
                                            <label class="btn btn-outline-secondary" for="Weekly">Weekly</label>

                                            <input type="radio" class="btn-check delivery_type" value="bi-Weekly" name="type" id="Bi-Weekly">
                                            <label class="btn btn-outline-secondary" for="Bi-Weekly">Bi-Weekly</label>
                                        </div>
                                    </div>
                                    <div class="step step_2" id="secondStep">
                                        <div class="card-box mb-3">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12" id="address-form1">
                                                    <label class="form-label" for="address1">Address 1</label>
                                                    <input type="text" class="form-control" name="address1" id="address1" disabled>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12" id="address-form2">
                                                    <label class="form-label" for="address2">Address 2</label>
                                                    <input type="text" class="form-control" name="address2" id="address2" disabled>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-12" id="city-form">
                                                    <label class="form-label" for="city">City</label>
                                                    <input type="text" class="form-control" name="city" id="city" disabled>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-12" id="state-form">
                                                    <label class="form-label" for="State">State</label>
                                                    <input type="text" class="form-control" name="state" id="state" disabled>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-12" id="zip-form">
                                                    <label class="form-label" for="zip">Zip</label>
                                                    <input type="text" class="form-control zip_input" name="zip" id="zip" disabled>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="step step_3" id="thirdStep">
                                        <div class="card-box mb-3">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12" id="fullname-form">
                                                    <label class="form-label" for="f_Name">Full Name</label>
                                                    <input type="text" class="form-control" name="f_Name" id="f_Name" disabled>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12" id="email-form">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" disabled>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12" id="busniess-form">
                                                    <label class="form-label" for="business_name">Business Name</label>
                                                    <input type="text" class="form-control" name="business_name" id="business_name" disabled>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12" id="phone-form">
                                                    <label class="form-label" for="phone">Phone</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" disabled>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12" id="altphone-form">
                                                    <label class="form-label" for="alt_phone">Alt Phone</label>
                                                    <input type="text" class="form-control alt_phone_input" name="alt_phone" id="alt_phone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step step_4" id="fourStep">
                                        <div class="card-box mb-3">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12" id="recipient-form">
                                                    <label class="form-label" for="full_name_recipient ">Full Name of Recipient </label>
                                                    <input type="text" class="form-control" name="full_name_recipient" id="full_name_recipient">
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12" id="recipientPhone-form">
                                                    <label class="form-label" for="recipient_phone">Recipient Phone </label>
                                                    <input type="text" class="form-control recipient_phone_input" name="recipient_phone" id="recipient_phone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step step_5" id="fiveStep">
                                        <div class="card-box mb-3">
                                            <div class="form-group col-lg-12 col-md-12" id="customerNote-form">
                                                <label class="form-label" for="customer_note">Customer Note </label>
                                                <textarea name="customer_note" rows="4" class="form-control customer_note_textarea" id="customer_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step step_6" id="sixStep">
                                        <div class="card-box mb-3">

                                        </div>
                                    </div>
                                </form>
                                <div class="col-lg-3 col-md-12 position-relative mt-5">
                                    <ul id="progressbar" class="text-center">
                                        <li class="active step0"></li>
                                        <li class="step0 address_li"></li>
                                        <li class="step0 yourInformation_li"></li>
                                        <li class="step0 recipientInfo_li"></li>
                                        <li class="step0 customerNotes_li"></li>
                                        <li class="step0 placeOrder_li"></li>
                                    </ul>
                                    <div class="card1">
                                        <h6 class="options">Options</h6>
                                        <h6 class="Address">Address</h6>
                                        <h6 class="YourInformation">Your Information</h6>
                                        <h6 class="RecipientInfo">Recipient Info</h6>
                                        <h6 class="CustomerNotes">Customer Notes</h6>
                                        <h6 class="PlaceOrder">Place Order</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
 @include('flashy::message')
 <script>
     $('#changePackage').change(function (e) {
         e.preventDefault();
         var packageId = $(this).find(':selected').data('packageid');
         $('.loading').css('display','block');
         $.ajax({
             type: "POST",
             url: "{{ route('getPackages') }}",
             data: {
                 packageId:packageId,
                 "_token": "{{ csrf_token() }}",
             },
             success: function (response) {
                 $('.loading').css('display','none')
                 console.log()
                 $('#getselectPackage').empty().append(response['html_view'])
             },
             error: function(data)
             {

             }
         });
     });

     $(document).on('click', '.openModal', function () {
         var pkgId = $(this).data('id');
         $.ajax({
             url: "{{route('selectPackage')}}",
             type:"POST",
             data:{
                 pkgId:pkgId,
                 _token:'{{ csrf_token() }}',
             },
             success: function (response) {
                 $('.loading').css('display','none')
                 console.log(response.selectPackage)
                 $('#checkoutModal').modal('show');
                 $('#packageImg').html(response.selectPackage.select_package_img);
                 $('#packageTitle').html('<h5> ' + response.selectPackage.title + '</h5>')
                 $('#packageAmount').html('<h5> ' + response.selectPackage.amount + '</h5>')
                 $('#packageDescription').html('<p> ' + response.selectPackage.description + '</p>')
             },
             error: function(data)
             {
             }
         });

     })

 </script>
 <script>
     $(document).ready(function() {
         $("#f_Name").prop("disabled", true);
         $("#email").prop("disabled", true);
         $("#business_name").prop("disabled", true);
         $("#phone").prop("disabled", true);
         $("#alt_phone").prop("disabled", true);
         $("#full_name_recipient").prop("disabled", true);
         $("#recipient_phone").prop("disabled", true);
         $("#customer_note").prop("disabled", true);

         $('.delivery_type').click(function() {
             $('.step_2').addClass('active');
             $('.step_2 input').prop("disabled", false);
             $('#progressbar .address_li').addClass('active');
         });
         $(".zip_input").blur(function() {
             $('.step_3').addClass('active');
             $('.step_3 input').prop("disabled", false);
             $('#progressbar .yourInformation_li').addClass('active');
         });
         $(".alt_phone_input").blur(function() {
             $('.step_4').addClass('active');
             $('.step_4 input').prop("disabled", false);
             $('#progressbar .recipientInfo_li').addClass('active');

         });
         $(".recipient_phone_input").blur(function() {
             $('.step_5').addClass('active');
             $('.step_5 textarea').prop("disabled", false);
             $('#progressbar .customerNotes_li').addClass('active');

         });
         $(".customer_note_textarea").blur(function() {
             $('.step_6').addClass('active');
             $('.step_6 input').prop("disabled", false);
             $('#progressbar .placeOrder_li').addClass('active');

         });

     });
 </script>
 <script>
 </script>
@endsection
