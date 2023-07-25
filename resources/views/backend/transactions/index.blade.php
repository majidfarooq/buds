@extends('backend.layouts.app')
@section('style')
  <style type="text/css">
  td.action {display: flex ; gap: 10px;}

  [data-title]:hover:after {opacity: 1 ; transition: all 0.1s ease 0.5s ; visibility: visible;}
  [data-title]:after {
    content: attr(data-title) ; background-color: #f8f9fc ; color: #4e73df ; font-size: 15px ; position: absolute ; padding: 1px 5px 2px 5px ; top: -35px ; left: 0 ; white-space: nowrap ; box-shadow: 1px 1px 3px #4e73df ; opacity: 0 ; border: 1px solid #4e73df ; z-index: 99999 ; visibility: hidden;
  }
  [data-title] {position: relative;}
  </style>
@endsection

@section('content')
  <div class="row">
  <div class="col-12">
    <div class="card border-0">
    @if ($message = \Illuminate\Support\Facades\Session::get('error'))
      <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
      </div>
    @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
      <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
      </div>
    @endif
    </div>
  </div>
  </div>
  <div class="container-fluid">
  <div class="card shadow shadow mb-4 user-list p-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-4">
      <h5>Transaction</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive user-package">
            <table class="table table-bordered table-striped" id="users">
                <thead>
                    <th>Name</th>
                    <th>Package</th>
                    <th>Payment Type</th>
                    <th>Quantity </th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th class="not-export-col"></th>
                </thead>
                <tbody id="ajaxSearchResults">
                    @if ($user_package_payments)
                    @foreach ($user_package_payments as $user_package_payment)
                    <tr role="row" class="even">
                        @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($user_package_payment->id)  @endphp
                        <td>{{ $user_package_payment->user_package->user->first_name }}{{ $user_package_payment->user_package->user->last_name }}  </td>
                        <td>{{ $user_package_payment->user_package->package->title }}<br>{{ $user_package_payment->user_package->type }}  </td>
                        <td> {{ $user_package_payment->type }} _ {{ $user_package_payment->deliveriesCount->count()}} _ {{ $user_package_payment->user_package_id}} _ {{ $user_package_payment->id}}</td>
                        <td> {{ $user_package_payment->quantity }}</td>
                        <td> @currency_format($user_package_payment->amount)</td>
                        <td> {{ \Carbon\Carbon::parse($user_package_payment->payment_date)->format('j M Y') }}</td>

                        <td class=" action">
                        <a href="{{ route('admin.transactions.show', $user_package_payment->id) }}">
                            <button type="submit" data-title="Show" class="btn btn-circle btn-success text-white"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>
                        @if($user_package_payment->type=='cc' && $user_package_payment->status !=='refunded')
                        <a href="{{ route('admin.transactions.refund', $user_package_payment->transection_id) }}">
                            <button type="submit" data-title="Refund" class="btn btn-circle btn-success text-white"><i class="fa fa-undo" aria-hidden="true"></i></button>
                        </a>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
      {{-- {!! $users->render() !!} --}}
    </div>
    </div>
  </div>

  </div>

<!-- Modal -->
<div class="modal fade" id="deactivateCustomer" tabindex="-1" aria-labelledby="deactivateCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body px-4 py-5 align-items-center text-center">
            {{-- <form method="post" action="{{ route('admin.users.deactivate') }}" id="deactivatingCustomer">
                <h2>Are you sure you want to Deactivate the Client?</h2>
                <p class="py-4">This will disable client’s ability to log-in and will not allow any BCRM or Business Activity by any sub-admin</p>
                @csrf
                <input type="hidden" name="user_id" value="">
                <div class="modal-footer d-flex justify-content-around border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Deactivation</button>
                </div>
            </form> --}}
        </div>
      </div>
    </div>
</div>




@endsection

@section('script')
  <script>
    function deactivateCustomer(elem){
        $('#deactivateCustomer').modal('show');
        $("form#deactivatingCustomer input[name=user_id]").val($(elem).data('userid'));
        console.log($(elem),$(elem).data('userid'));
    }


  let message = 'Your Message Will Show Here.';
  $(document).ready(function() {
    var user_table= $('#users').DataTable();
    @if(isset($user->first_name))
    user_table.fnFilter('{{$user->first_name}}');
    @endif
  });

  </script>
  @include('flashy::message')

  <script>
    function searchResultsAJAX(elem) {
      $.post('{{ route('admin.users.index') }}', {
      _token: '{{ csrf_token() }}',
      search: $(elem).val(),
      }, function(data) {
        if (data['status'] == true) {$('#ajaxSearchResults').empty().append(data['view']);}
      });
    }



  </script>
@endsection
