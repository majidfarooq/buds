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
        <h5>Subscription Details</h5>
      </div>
      <div class="card-body row">
          <div class="col-md-7 col-sm-12 p-0">
              <div class="row mx-0 mb-3">
                  <div class="col-4 info-type"><h6>Package</h6></div>
                  <div class="col-8 detail-type"><p>{{ (isset($user_package->package->title) ? $user_package->package->title : '') }}</p></div>
              </div>
              <div class="row mx-0 mb-3">
                  <div class="col-4 info-type"><h6>Amount</h6></div>
                  <div class="col-8 detail-type"><p> ${{  number_format($user_package->package->amount, 2, ".", ",")}}</p></div>
              </div>
              <div class="row mx-0 mb-3">
                  <div class="col-4 info-type"><h6>Delivery</h6></div>
                  <div class="col-8 detail-type"><p>{{ (isset($user_package->type) ? ($user_package->type) : '') }}</p></div>
              </div>
              <div class="row mx-0 mb-3">
                  <div class="col-4 info-type"><h6>Since</h6></div>
                  <div class="col-8 detail-type"><p>{{ (isset($user_package->day) ? $user_package->day : '') }}</p></div>
              </div>
              <div class="row mx-0 mb-3">
                  <div class="col-4 info-type"><h6>Since</h6></div>
                  <div class="col-8 detail-type"><p>{{ (isset($user_package->description) ? $user_package->description : '') }}</p></div>
              </div>

          </div>
          <div class="col-md-12 col-sm-12 p-0" >
            <div class="user_subscription_list border-1 p-3">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0"> Subscriptions(s)</p>
              </div>

            </div>
            <div class="user_deliveries mt-4">
              <table class="table table-bordered">
                <thead>
                    <th>Date</th><th>Amount</th><th>Status</th>
                </thead>
                <tbody>
                  @foreach ($user_package->payments as $payment)
                    <tr role="row"><td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('j M Y') }}</td><td>${{  number_format($payment->amount, 2, ".", ",")}}</td><td>Paid - {{$payment->type}}</td></tr>
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

  </script>

@endsection

