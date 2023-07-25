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
          <div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div>
        @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
          <div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong></div>
        @endif
        <!--end card-body-->
      </div>
    </div>

    <!--end col-->

  </div>

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow shadow mb-4 user-list">
      <div class="d-flex justify-content-between align-items-center py-3 mx-3">
        <h5>Administrators</h5>
          @if (Auth::user()->role == 'super_admin')
              <a class="btn btn-primary btn-user" href="{{ route('admin.subadmins.create') }}">
                  <h4>Create New Administrator</h4>
              </a>
          @else
          @endif

      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="pages">
            <thead>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Created At</th>
              <th>Action</th>
            </thead>
            <tbody>
              @if ($admins)
                @php $id=1; @endphp
                @foreach ($admins as $admin)
                  <tr role="row" class="even">
                    @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($admin->id)  @endphp
                    <td class="sorting_1">{{ $id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                      @if ($admin->role == 'super_admin')
                        Admin
                      @elseif ($admin->role == 'manager')
                        Sub admin
                      @endif
                      {{-- {{ str_replace('_', ' ', $admin->role) }} --}}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('d F, h:m A, Y') }}</td>
                    <td class=" action">
{{--                       <a href="{{ route('admin.subadmins.show', $encrypted) }}">--}}
{{--                          <button type="submit" data-title="Show" class="btn btn-circle">--}}
{{--                            <i class="fas fa-eye" aria-hidden="true"></i>--}}
{{--                          </button>--}}
{{--                        </a>--}}
                      @if (Auth::user()->role == 'super_admin')
                            <a href="{{ route('admin.subadmins.edit', $encrypted) }}">
                                <button type="submit" data-title="Edit" class="btn btn-circle btn-success text-white">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                            </a>
                            <a onclick="return confirm(' you want to delete?');"
                               href="{{ route('admin.subadmins.destroy', $admin->id) }}">
                                <button type="submit" data-title="Delete" class="btn btn-circle btn-success text-white">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </a>
                      @else
                        {{-- <a><button type="submit" data-title="No action Allowed" class="btn btn-circle"><i class="fas fa-times"></i></button></a> --}}
                      @endif
                    </td>

                  </tr>
                  @php $id++; @endphp
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
  <script></script>
  @include('flashy::message')

  <script></script>
@endsection
