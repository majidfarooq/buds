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
        <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
      </div>
      <div class="card-body row">
          <div class="col-md-7 col-sm-12 p-0">
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->first_name ) ? $user->first_name : '') }}{{' '}}{{ (isset($user->last_name ) ? $user->last_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Email</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->email) ? $user->email : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Phone</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->phone) ? $user->phone : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Business Name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->business_name) ? $user->business_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Email</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->email) ? $user->email : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>recipient_name</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->recipient_name) ? $user->recipient_name : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>recipient_phone</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->recipient_phone) ? $user->recipient_phone : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>notes</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->notes) ? $user->notes : '') }}</p></div>
            </div>
            <h6>Billing Address</h6>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Co-ordinates</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_coordinates) ? $user->billing_coordinates : '') }}</p></div>
            </div>    
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Address 1</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_address1) ? $user->billing_address1 : '') }}</p></div>
            </div>  
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Address 2</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_address2) ? $user->billing_address2 : '') }}</p></div>
            </div>          
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>City</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_city) ? $user->billing_city : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>State</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_state) ? $user->billing_state : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Zipcode</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->billing_zip) ? $user->billing_zip : '') }}</p></div>
            </div>
            <h6>Delivery Address</h6>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Co-ordinates</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_coordinates) ? $user->delivery_coordinates : '') }}</p></div>
            </div>        
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Address 1</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_address1) ? $user->delivery_address1 : '') }}</p></div>
            </div>        
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Address 2</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_address2) ? $user->delivery_address2 : '') }}</p></div>
            </div>         
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>City</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_city) ? $user->delivery_city : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>State</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_state) ? $user->delivery_state : '') }}</p></div>
            </div>
            <div class="row mx-0 mb-1">
              <div class="col-4 info-type"><h6>Zipcode</h6></div>
              <div class="col-8 detail-type"><p>{{ (isset($user->delivery_zip) ? $user->delivery_zip : '') }}</p></div>
            </div>
          </div>
          <div class="col-md-5 col-sm-12 p-0" >
            <div class="row user_subscription_list">
            <h1> Subscriptions <a href="">Manage Subscriptions</a></h1>
            <div class="row user_subscription">
              <div class="col-3"><span class="small">Package</span> <br> Delux</div>
              <div class="col-3"><span class="small">Amount</span> <br> $ 144.00</div>
              <div class="col-3"><span class="small">Delivery</span> <br> Weekly</div>
              <div class="col-3"><span class="small">Since</span> <br> 22 May, 22</div>
            </div>
            </div>
            <div class="row user_deliveries">
              <table>
                <thead>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <tr role="row">
                      <td>22 May, 22</td>
                      <td>$ 144.00</td>
                      <td>Paid - CC</td>
                    </tr>
                    <tr role="row">
                      <td>23 May, 22</td>
                      <td>$ 144.00</td>
                      <td>Paid - Cash</td>
                    </tr>
                    <tr role="row">
                      <td>24 May, 22</td>
                      <td>$ 144.00</td>
                      <td>Due</td>
                    </tr>
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

  <script></script>

@endsection

