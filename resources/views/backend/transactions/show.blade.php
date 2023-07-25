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
  <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card border-0">
            @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong> </div>
            @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                <div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div>
            @endif
        </div>
      <div class="card-header py-3">
        <h5>Transaction Details</h5>
      </div>
      <div class="card-body">
          <div class="col-md-12 col-sm-12 p-0">
              <div class="row">
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Name</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->user_package->user->first_name ) ? $user_package_payment->user_package->user->first_name : '') }}{{' '}}{{ (isset($user_package_payment->user_package->user->last_name ) ? $user_package_payment->user_package->user->last_name : '') }}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Package Name</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->user_package->package->title) ? $user_package_payment->user_package->package->title : '') }}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Package Type</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->user_package->type) ? $user_package_payment->user_package->type : '') }}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Payment Type</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->type) ? $user_package_payment->type : '') }}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Quantity</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset( $user_package_payment->quantity) ?  $user_package_payment->quantity : '') }}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Amount</h6></div>
                  <div class="col-12 detail-type"><p>{{--@currency_format($user_package_payment->amount)--}}</p></div>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Deliveries</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->deliveries_count) ? $user_package_payment->deliveries_count : '') }}</p></div>
              </div>
                <div class="col-md-4 col-sm-12 mb-3">
              <div class="col-12 info-type"><h6>Description</h6></div>
              <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->description) ? $user_package_payment->description : '') }}</p></div>
            </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Transection id</h6></div>
                  <div class="col-12 detail-type"><p>{{ (isset($user_package_payment->transection_id) ? $user_package_payment->transection_id : '') }}</p></div>
                </div>
                  <div class="col-md-4 col-sm-12 mb-3">
                      <div class="col-12 info-type"><h6>Payment Date</h6></div>
                      <div class="col-12 detail-type"><p>{{ \Carbon\Carbon::parse($user_package_payment->payment_date)->format('j M Y') }}</p></div>
                  </div>
                  <div class="col-md-4 col-sm-12 mb-3">
                  <div class="col-12 info-type"><h6>Attachment</h6></div>
                  <div class="col-12 detail-type">
                      <div class=" img-size">
                          @if (isset($user_package_payment->attachment) && !empty($user_package_payment->attachment))
                              <img alt="Admin Photo" width="40px" height="40px" id="current_Image"
                                   class="img-profile"
                                   src="{{ asset('public' . \Illuminate\Support\Facades\Storage::url($user_package_payment->attachment)) }}"
                                   alt="amherst">
                          @else
                              <img class="img-profile"
                                   src="{{ asset('public/assets/backend/img/no-image.jpg') }}" alt="amherst">
                          @endif
                      </div>
                  </div>
                </div>
              </div>
          </div>

          <div class="table-responsive user-package col-md-5 col-sm-12">
              <table class="table table-bordered table-striped" id="transaction">
                  <thead>
                  <th>Delivery Date</th>
                  <th>Route</th>
                  </thead>
                  <tbody id="ajaxSearchResults">
                  @if ($user_package_payment->deliveries)

                      @foreach ($user_package_payment->deliveries as $dilevery)
                          <tr role="row" class="even">
                              <td> {{ \Carbon\Carbon::parse($dilevery->delivery_day->delivery_date)->format('j M Y') }}</td>
                              <td> {{ $dilevery->route }}</td>
                          </tr>
                      @endforeach
                  @endif
                  </tbody>
              </table>
              {{-- {!! $users->render() !!} --}}
          </div>

      </div>
  </div>

@endsection

@section('script')

  @include('flashy::message')
  <script src="https://js.stripe.com/v3/"></script>
  <script type="application/javascript">
      let message = 'Your Message Will Show Here.';
      $(document).ready(function() {
          $('#transaction').dataTable( {
              "bPaginate": true,
              "bFilter": false,
              "bInfo": false,
              "lengthChange": false
          } );
      });
  </script>


@endsection

