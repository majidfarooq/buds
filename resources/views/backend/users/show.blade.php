@extends('backend.layouts.app')

@section('style')

  <style type="text/css">

    td.action {
      display: flex;
      gap: 10px;
    }

    [data-title]:hover:after {
      opacity: 1;
      transition: all 0.1s ease 0.5s;
      visibility: visible;
    }

    [data-title]:after {
      content: attr(data-title);
      background-color: #f8f9fc;
      color: #4e73df;
      font-size: 15px;
      position: absolute;
      padding: 1px 5px 2px 5px;
      top: -35px;
      left: 0;
      white-space: nowrap;
      box-shadow: 1px 1px 3px #4e73df;
      opacity: 0;
      border: 1px solid #4e73df;
      z-index: 99999;
      visibility: hidden;
    }

    [data-title] {
      position: relative;
    }

  </style>

@endsection

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-0">
            @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong> </div>
            @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                <div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div>
            @endif
        </div>
      <div class="card-header py-3">
        <h5>Customer Details</h5>
      </div>
      <div class="card-body row">
          <div class="col-md-7 col-sm-12 p-0">
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->first_name ) ? $user->first_name : '') }}{{' '}}{{ (isset($user->last_name ) ? $user->last_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Email</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->email) ? $user->email : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Phone</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->phone) ? $user->phone : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Business Name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->business_name) ? $user->business_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Email</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->email) ? $user->email : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Recipient Name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->recipient_name) ? $user->recipient_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Recipient Phone</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->recipient_phone) ? $user->recipient_phone : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>notes</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->notes) ? $user->notes : '') }}</p></div>
            </div>
            <h4>Billing Address</h4>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Co-ordinates</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_coordinates) ? $user->billing_coordinates : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Address 1</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_address1) ? $user->billing_address1 : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Address 2</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_address2) ? $user->billing_address2 : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>City</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_city) ? $user->billing_city : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>State</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_state) ? $user->billing_state : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Zipcode</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_zip) ? $user->billing_zip : '') }}</p></div>
            </div>
            <h4>Delivery Address</h4>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Co-ordinates</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_coordinates) ? $user->delivery_coordinates : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Address 1</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_address1) ? $user->delivery_address1 : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Address 2</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_address2) ? $user->delivery_address2 : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>City</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_city) ? $user->delivery_city : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>State</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_state) ? $user->delivery_state : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>Zipcode</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_zip) ? $user->delivery_zip : '') }}</p></div>
            </div>
          </div>
          <div class="col-md-5 col-sm-12 p-0 subscriptions-right">
            <div class=" user_subscription_list border-1 p-3">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0"> Subscriptions(s)</p>
                <a href="#">Manage Subscriptions</a>
              </div>

            @foreach ($user->user_packages as $assigned)
            <div class="row user_subscription mb-3">
              <div class="col-3"><label class="small">Package</label> <p> {{ $assigned->package->title}}</p></div>
              <div class="col-3"><label class="small">Amount</label> <p> ${{  number_format($assigned->package->amount, 2, ".", ",")}} </p></div>
              <div class="col-3"><label class="small">Delivery</label> <p> {{$assigned->type}}</p></div>
              <div class="col-3"><label class="small">Since</label> <p>{{ \Carbon\Carbon::parse($assigned->created_at)->format('j M Y') }}</p></div>
              <div class="col-4 dollar-section">
                  <a href="{{ route('admin.users.assign_total_credits', $assigned->id) }}"><label class="small">Total Credits
                          @if ($assigned->remaining_deliveries < 0)
                              <img src="{{asset('/public/assets/backend/img/dollar-cancel.png')}}">
                          @else ($assigned->remaining_deliveries )
                              <img src="{{asset('/public/assets/backend/img/dollar-succes.png')}}">
                          @endif
                          </label>
                  </a>
              </div>
                @if ($assigned->remaining_deliveries < 0)
              <div class="col-4 assign-red"><label class="small">({{$assigned->remaining_deliveries}} Payments)</label></div>
              <div class="col-4 rate-section assign-red"><label class="small">${{ number_format($assigned->remaining_deliveries * $assigned->package->amount, 2, ".", ",")}}</label></div>
                @else ($assigned->remaining_deliveries )
                    <div class="col-4"><label class="small">({{$assigned->remaining_deliveries}} Payments)</label></div>
                    <div class="col-4 rate-section"><label class="small">${{ number_format($assigned->remaining_deliveries * $assigned->package->amount, 2, ".", ",")}}</label></div>
                @endif

                @if ($assigned->status== 'active')
                <div class="col-6 dollar-section mt-3 mb-3">
              </div>
              <div class="col-6 dollar-section d-flex justify-content-end align-items-center mt-3 mb-3">
                  <a onclick="return confirm('Do you want to Delete Subscription? It will delete all related Deleveries.');" href="{{ route('admin.user_packages.destroy', $assigned->id) }}">
                    <button type="submit" style="margin-right: 10px" data-title="Delete" class="btn btn-circle btn-primary text-white"><i style="border:none" class="fas fa-trash-alt"></i></button>
                  </a>
                  <button data-title="Suspend Deliveries" data-id="{{ $assigned->id}}" class="btn btn-primary text-white SuspendDeliveries">Suspend Deliveries</button>
              </div>
                @else
                    <div class="col-6 dollar-section mt-3 mb-3">
                        <label>Suspended until: {{ $assigned->suspended_until}}</label>
                    </div>
                      <div class="col-6 dollar-section d-flex justify-content-end align-items-center mt-3 mb-3">
                        <a href="{{ route('admin.user_packages.activate_delivery', $assigned->id) }}" data-title="Activate Deliveries" data-id="{{ $assigned->id}}" class="btn btn-success text-white">Activate Deliveries</a>
                    </div>
                @endif
            </div>
            @endforeach
            @if($user->deactivated === 1)
            <p>Subscriptions can only be assigned to active customers</p>
            @else
            <a class="d-flex justify-content-end my-3" href="{{ route('admin.users.assign_package', $user->id) }}">
              <button type="submit" data-title="Delete" class="btn btn-primary text-white">Add Subscription</button>
            </a>
            @endif
            </div>
          <div class="user_deliveries mt-4">
              <div class=" user_subscription_list border-1 p-3">
                  <div class="d-flex justify-content-between align-items-center">
                      <p class="mb-0"> Paymemt Method</p>
                  </div>
                  @if (isset($user->stripe_id) && !empty($user->stripe_id))
                    @if(isset($paymentMethods) && !empty($paymentMethods))
                    @else
                      <p style="color:red">The stripe id of this user doesnot exist</p>
                    @endif
                  @endif
                  @if(isset($paymentMethods) && !empty($paymentMethods))
                          @foreach($paymentMethods->data as $card)
                              <div class="d-flex justify-content-between align-items-center bd-highlight paymemt-method mb-4" role="row">
                                  <div class="paymentMethodsnumber">
                                      <img alt="Admin Photo" width="40px" id="current_Image"
                                           class="img-profile"
                                           src="{{ asset('public/assets/backend/img/'.$card->card->brand.'.png') }}"
                                           alt="amherst">
                                      *************{{$card->card->last4}}
                                  </div>
                                  <div class="action">
                                      @if(isset($customerStripe->invoice_settings->default_payment_method) && $customerStripe->invoice_settings->default_payment_method==$card->id)
                                          <button data-title="Mark Default" type="button" class="btn btn-circle btn-success text-white"><i class="fa fa-check-square" aria-hidden="true"></i>
                                          </button>
                                          {!! Form::open(['route' => 'admin.users.createUserAsingCard','id' => 'registerAdmin']) !!}
                                          <input type="hidden" name="customer_id" value="{{$customerStripe->id}}">
                                          <input type="hidden" name="payment_method" value="{{$card->id}}">
                                          <button type="submit" data-title="Delete" name="delete" value="1" class="btn btn-circle btn-success text-white"><i class="fas fa-trash-alt"></i></button>
                                          {!! Form::close() !!}
                                      @else
                                          {!! Form::open(['route' => 'admin.users.createUserAsingCard','id' => 'registerAdmin']) !!}
                                          <input type="hidden" name="customer_id" value="{{$customerStripe->id}}">
                                          <input type="hidden" name="payment_method" value="{{$card->id}}">
                                          <button type="submit" data-title="Mark As Default" name="default" value="1" class="btn btn-circle btn-success text-white"><i class="fa fa-square-o"></i>
                                          </button>
                                          <button type="submit" data-title="Delete" name="delete" value="1" class="btn btn-circle btn-success text-white"><i class="fas fa-trash-alt"></i></button>
                                          {!! Form::close() !!}
                                      @endif
                                  </div>
                              </div>
                          @endforeach

                  @endif
                  <div class="d-flex justify-content-end my-3">
                      <button id="AddPaymentShow" data-title="Add Payment" class="btn btn-primary text-white">Add Payment</button>
                  </div>
                  <div class="mt-4 new card" id="newCard" style="display: none">
                      {!! Form::open(['route' => 'admin.users.addnewCardCustomer','id' => 'addnewCardCustomer']) !!}
                      <div class="form-row payment-form-add">
                          <div class="inner-form-card">
                              <label for="card-element">
                                  Credit or debit card
                              </label>
                              <div id="card-element"></div>
                              <input type="hidden" name="stripeToken" id="stripeToken" value="">
                              <input type="hidden" name="user_id" value="{{$user->id}}">
                              <div id="card-errors" role="alert"></div>
                          </div>
                      </div>
                      <button type="submit" name="default" value="1" class="btn btn-primary text-white w-50 mx-auto">Submit</button>
                      {!! Form::close() !!}
                  </div>
              </div>
              <div class="d-flex justify-content-end my-3">
                  <a href="{{ route('admin.transactions.user_transections', $user->slug) }}" id="ShowTransaction" data-title="Show Transaction" class="btn btn-primary text-white">Show Transaction</a>
              </div>
          </div>

          </div>
      </div>
    </div>
  </div>
  <div class="modal fade modalsuspendDeliveries" id="modalsuspendDeliveries" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              {!! Form::open(["route" => ["admin.user_packages.suspend_delivery"],"id"=>"suspend_delivery", "files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
              <input type="hidden" class="form-control" name="user_package_id" id="idkl" value="">

              <div class="modal-body">
                  <div class="col-md-6 col-sm-12 mx-auto">
                  <h5 class="modal-title w-100" id="exampleModalLabel">Suspend Deliveries</h5>
                  <p>For: Charles Dawson</p>
                  <p>Deluxe Package - Weekly</p>
                  </div>
                  <div class="d-flex align-items-center">
                      <div class="suspend-deliveries-text text-center col-md-7 col-sm-12">
                      <h4>Suspend Deliveries until</h4>
                      <p>Select a date to specify when would you
                          like to start seeing deliveries auto-activated.</p>
                      </div>
                      <div class="suspend-deliveries-text col-md-5 col-sm-12">
                          <input type="date" name="suspended_until" id="suspended_until" class="form-control" required>
                      </div>
                  </div>
              </div>
              <div class="row my-4">
                  <div class="offset-md-3 col-md-6 col-sm-12 text-center">
                  <button type="submit" class="btn btn-primary">Confirm
                  </button>
                  </div>
                  <div class="col-md-3 col-sm-12 text-end">
                  <button type="button" class="btn" data-dismiss="modal">Close</button>
                  </div>

              </div>
              {!! Form::close() !!}

          </div>
      </div>
  </div>

@endsection

@section('script')

  @include('flashy::message')
  <script>
      $(".SuspendDeliveries").click(function () {
          var ids = $(this).attr('data-id');
          $("#idkl").val( ids );
          $('#modalsuspendDeliveries').modal('show');
      });
      $(document).ready(function(){
          $("#AddPaymentShow").click(function(){
              $("#newCard").fadeToggle(300);
          });
      });
  </script>
  <script src="https://js.stripe.com/v3/"></script>
  <script type="application/javascript">
      document.getElementById('suspended_until').valueAsDate = new Date();
      var stripe = Stripe('pk_test_P6rZrxopN6TvH3DdvwFH8JhE');
      var elements = stripe.elements();
      var card = elements.create('card', {
          hidePostalCode: true,
          style: {
              base: {
                  color: '#32325d',
                  fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                  fontSmoothing: 'antialiased',
                  fontSize: '16px',
                  '::placeholder': {
                      color: '#aab7c4'
                  }
              },
              invalid: {
                  color: '#fa755a',
                  iconColor: '#fa755a'
              }
          }
      });
      card.mount('#card-element');
      card.mount('#card-element');
      card.on('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
              displayError.textContent = event.error.message;
          } else {
              displayError.textContent = '';
          }
      });
      var form = document.getElementById('addnewCardCustomer');
      form.addEventListener('submit', function(event) {
          event.preventDefault();
          stripe.createToken(card).then(function(result) {
              if (result.error) {
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
              } else {
                  $('#stripeToken').val(result.token.id)
                  $("#addnewCardCustomer").submit();
              }
          });
      });

      function stripeTokenHandler(token) {
          var form = document.getElementById('payment-form-add');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);
          form.submit();
      }

  </script>
  <script>
      function openUserForm(){
          $('#showPackages').modal('show');
      }
      $('input:radio[name="type"]').change(
          function(){
              if ($(this).is(':checked') && $(this).val() == 'other') {
                  $("#collectCash").css("display", "block");
                  $("#subscribeCard").css("display", "none");
              }else{
                  $("#subscribeCard").css("display", "block");
                  $("#collectCash").css("display", "none");
              }
          });
      $("#userAssignPayment").validate({
          rules: {
              "package_id": {
                  required: true,
              },
              "delivery_frequence": {
                  required: true,
              },
              "quantity": {
                  required: true,
              },
              "amount": {
                  required: true,
              },
              "payment_date": {
                  required: true,
              }
          },
          submitHandler: function(form) {
              return true;
          }
      });
  </script>

@endsection

