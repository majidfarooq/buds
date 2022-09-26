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
    <div class="d-flex justify-content-between align-items-center pt-3 mx-3">
      <h5>Customers</h5>
    </div>
    <div class="d-flex justify-content-end p-1 mx-3 mb-4">
            <a class="btn btn-primary btn-user" href="{{ route('admin.users.create') }}"><h4 class="mb-0">Create New Customer</h4></a>
    </div>
    <div class="d-flex justify-content-end p-1 mx-3">
        {{-- <div class="new-leader">
        <h6>New Leads: {{ $leads }}</h6>
        <h6>Total Clients: {{ $total }}</h6>
        <h6>Active Clients: {{ $active }}</h6>
        </div> --}}
        <div class="new-leader buy-email">
        <div class="input-group">
        <div class="form-outline d-flex align-items-center">
          <label class="mr-2 mb-0">Search</label>
          <input type="search" onkeyup="searchResultsAJAX(this)" id="form1" placeholder="search" class="form-control" /></div>
        </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="">
                <thead>
                    <th>DOJ</th>
                    <th>Cystomer Name</th>
                    <th>Email</th>
                    <th>Delivery Area </th>
                    <th>Status</th>
                    <th class="not-export-col"></th>
                </thead>
                <tbody id="ajaxSearchResults">
                    @if ($users)

                    @foreach ($users as $user)
                    <tr role="row" class="even">
                        @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($user->id)  @endphp
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('m-d-Y') }}</td>
                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td> {{ $user->email }}, <br>{{ $user->phone }}</td>
                        <td>{{ $user->delivery_address1 . ', '.$user->delivery_address2}}, <br>{{ $user->delivery_zip . ', '.$user->delivery_city}} </td>
                        <td align="center" class="status status-color">{{ $user->finalStatus }}</td>
                       
                        <td class=" action">
                            <a href="{{ route('admin.users.show', $user->slug) }}">
                                <button type="submit" data-title="Show" class="btn btn-circle btn-success text-white"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            </a>
                            @if ($user->isAsinged == 1)
                                <a href="{{ route('admin.users.edit', $encrypted) }}"><button type="submit" data-title="Edit" class="btn btn-circle btn-success text-white"><i class="fas fa-user-edit"></i></button></a>
                                @if (Auth::user()->role == 'super_admin')
                                    <a class="d-none" a onclick="return confirm(' you want to delete?');" href="{{ route('admin.users.destroy', $user->id) }}">
                                        <button type="submit" data-title="Delete" class="btn btn-circle btn-success text-white"><i class="fas fa-trash-alt"></i></button>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
      {!! $users->render() !!}
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
    $('#users').DataTable({
      dom: "Blfrtip",
      buttons: [
        {text: '<i class="fas fa-copy"></i>',title: 'User Copy',titleAttr: 'copy',extend: 'copy',orientation: 'portrait',pageSize: 'A4',messageTop: message,className: 'btn-primary my-2 mr-2',exportOptions: {columns: ':visible:not(.not-export-col)'}},
        {text: '<i class="fas fa-file-csv"></i>',title: 'User Csv',titleAttr: 'Csv',extend: 'csvHtml5',orientation: 'portrait',pageSize: 'A4',messageTop: message,className: 'btn-primary my-2 mr-2',exportOptions: {columns: ':visible:not(.not-export-col)'}},
        {text: '<i class="fas fa-file-excel"></i>',title: 'User Excel',titleAttr: 'Excel',extend: 'excelHtml5',orientation: 'portrait',pageSize: 'A4',messageTop: message,className: 'btn-primary my-2 mr-2',exportOptions: {columns: ':visible:not(.not-export-col)'}},
        {text: '<i class="fas fa-file-pdf"></i>',title: 'User PDF',titleAttr: 'PDF',extend: 'pdfHtml5',orientation: 'portrait',pageSize: 'A4',messageTop: message,className: 'btn-primary my-2 mr-2',exportOptions: {columns: ':visible:not(.not-export-col)',}},
        {text: '<i class="fas fa-print"></i>',title: 'User Print',titleAttr: 'Print',extend: 'print',orientation: 'portrait',pageSize: 'A4',messageTop: message,className: 'btn-primary my-2 mr-2',exportOptions: {columns: ':visible:not(.not-export-col)',}},
      ],
    "processing": true,
    "serverSide": true,
    "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]],
    "autoFill": true,
    // "stateSave": true,
    // "scrollY": 200,
    // "paging": false,
    // "responsive": true,
    // "scrollX": true,
    "pagingType": "full_numbers",
    "ajax": {
      "url": "{{ URL::route('admin.users.index') }}",
      "dataType": "json",
      "type": "POST",
      "data": {
      _token: "{{ csrf_token() }}"
      }
    },
    "columns": [
      {"data": "id"},
      {"data": "first_name"},
      {"data": "email"},
      {"data": "deleted_at"},
      {"data": "created_at"},
      {"data": "action",className: "action",colspan: "1"},
    ],
    order: [
      [4, 'desc']
    ]
    });
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
