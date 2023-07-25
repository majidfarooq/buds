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
    <!--end card-body-->
    </div>
  </div>
  <!--end col-->

  </div>

  <!-- Begin Page Content -->
  <div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow shadow mb-4 user-list p-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-4">
      <h5 class="w-100">Customers
        <a class="btn btn-primary btn-user float-right" href="{{ route('admin.users.create') }}"><h4 class="mb-0">Create New Customer</h4></a></h5>
    </div>
    <div class="d-flex justify-content-end p-1 mb-4">

    </div>

    <div class="card-body p-0">
        <div class="table-responsive user-package">
            <table class="table table-bordered table-striped" id="users">
                <thead>
                    <th>DOJ</th>
                    <th>Customer Name</th>
                    <th>Contact </th>
                    <th>Delivery Address </th>
                    <th>Status</th>
                    <th class="not-export-col"></th>
                </thead>
                <tbody id="ajaxSearchResults">
                    @if ($users)

                    @foreach ($users as $user)
                    <tr role="row" class="even">
                        @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($user->id)  @endphp
                        <td>
                            {{ \Carbon\Carbon::parse($user->created_at)->format('j M Y') }}
                        </td>
                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td> {{ $user->email }}, <br>{{ $user->phone }}</td>
                        <td>{{ $user->delivery_address1 . ', '.$user->delivery_address2}}, <br>{{ $user->delivery_zip . ', '.$user->delivery_city}} </td>
                        <td align="center" class="status status-color">{{ $user->finalStatus }}</td>

                        <td class=" action">
                            <a href="{{ route('admin.users.show', $user->slug) }}">
                                <button type="submit" data-title="Show" class="btn btn-circle btn-success text-white"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->slug) }}"><button type="submit" data-title="Edit" class="btn btn-circle btn-success text-white"><i class="fas fa-user-edit"></i></button></a>
                            @if($user->deactivated === 0)
                            <a onclick="return confirm('Do you want to Deactivate user? It will delete all related subscriptions.');" href="{{ route('admin.users.deactivate', $user->id) }}">
                                <button type="submit" data-title="Deactivate" class="btn btn-circle btn-success text-white"><i class="fas fa-user-times"></i></button>
                            </a>
                            @else
                            <a onclick="return confirm('Do you want to Activate user?');" href="{{ route('admin.users.activate', $user->id) }}">
                                <button type="submit" data-title="Activate" class="btn btn-circle btn-success text-white"><i class="fas fa-user-plus"></i></button>
                            </a>
                            @endif
                            {{-- @if ($user->isAsinged == 1)
                                @if (Auth::user()->role == 'super_admin')@endif
                            @endif --}}
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
    $('#users').DataTable();
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
