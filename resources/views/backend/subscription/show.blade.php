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
  <div class="row">
    <div class="col-12">
      <div class="card border-0">
        @if ($message = \Illuminate\Support\Facades\Session::get('error'))
          <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong> </div>
        @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
          <div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div>
      @endif
      </div>
    </div>
    <!--end col-->
  </div>
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
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
              <div class="col-4 info-type"><h6>recipient_name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->recipient_name) ? $user->recipient_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-3">
              <div class="col-4 info-type"><h6>recipient_phone</h6></div>
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
          <div class="col-md-5 col-sm-12 p-0" >
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

              <div class="col-4 dollar-section"><a href="{{ route('admin.users.assign_total_credits', $assigned->id) }}"><label class="small">Total Credits <i class='fas fa-dollar-sign'></i></label></a></div>
              <div class="col-4"><label class="small">({{$assigned->remaining_deliveries}} Payments)</label></div>
                <div class="col-4 rate-section"><label class="small">$864.00</label>
                </div>

            </div>
            @endforeach
            <a class="d-flex justify-content-end my-3" href="{{ route('admin.users.assign_package', $user->id) }}">
              <button type="submit" data-title="Delete" class="btn btn-primary text-white">Add Subscription</button>
            </a>
            </div>
            <div class="user_deliveries mt-4">
              <table class="table table-bordered">
                <thead>
                    <th>Date</th><th>Amount</th><th>Status</th>
                </thead>
                <tbody>
                  @foreach ($user->payments as $payment)
                    <tr role="row"><td>{{$payment->payment_date}}</td><td>${{$payment->amount}}</td><td>Paid - {{$payment->type}}</td></tr>
                  @endforeach

                </tbody>
              </table>
            </div>


          </div>
      </div>
    </div>

  </div>

@endsection

@section('script')

  @include('flashy::message')

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

