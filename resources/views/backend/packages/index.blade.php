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
    <div class="d-flex justify-content-between align-items-center pt-3">
      <h5 class="w-100">Packages
        <a class="btn btn-primary btn-user float-right" href="{{ route('admin.packages.create') }}"><h4 class="mb-0">Create New Package</h4></a>
      </h5>
    </div>
    <div class="d-flex justify-content-end p-1 mb-4"></div>
    <div class="card-body p-0">
      <div class="table-responsive user-package">
        <table class="table table-bordered table-striped" id="packages">
          <thead>
            <th>ID</th>
            <th>Package Title</th>
            <th>Cost Price</th>
            <th>Tax </th>
            <th>Delivery Fee</th>
            <th>Total Price</th>
            <th class="not-export-col"></th>
          </thead>
          <tbody id="ajaxSearchResults">
            @if ($packages)
              @foreach ($packages as $package)
              <tr role="row" class="even">
                @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($package->id)  @endphp
                <td>{{ $package->id }}</td>
                <td>{{ $package->title }}</td>
                <td> @currency_format($package->price) </td>
                <td>@percent_format($package->tax)</td>
                <td>@currency_format($package->delivery_fee)</td>
                <td>@currency_format($package->amount)</td>

                <td class=" action">
                  <a href="{{ route('admin.packages.edit', $package->slug) }}"><button type="submit" data-title="Edit" class="btn btn-circle btn-success text-white"><i class="fas fa-user-edit"></i></button></a>
                  <a onclick="return confirm('Do you want to delete?');" href="{{ route('admin.packages.destroy', $package->id) }}">
                    <button type="submit" data-title="Delete" class="btn btn-circle btn-success text-white"><i class="fas fa-trash-alt"></i></button>
                  </a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  </div>

@endsection

@section('script')
  <script>
    // function deactivateCustomer(elem){
    //     $('#deactivateCustomer').modal('show');
    //     $("form#deactivatingCustomer input[name=user_id]").val($(elem).data('userid'));
    //     console.log($(elem),$(elem).data('userid'));
    // }


  let message = 'Your Message Will Show Here.';
  $(document).ready(function() {
    $('#packages').DataTable();
  });

  </script>
  @include('flashy::message')

  <script>
    function searchResultsAJAX(elem) {
      $.post('{{ route('admin.packages.index') }}', {
      _token: '{{ csrf_token() }}',
      search: $(elem).val(),
      }, function(data) {
        if (data['status'] == true) {$('#ajaxSearchResults').empty().append(data['view']);}
      });
    }



  </script>
@endsection
