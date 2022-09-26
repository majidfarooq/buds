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

    .container-fluid {
      padding: 0px
    }

    .navbar-expand {
      margin: 0px !important;
    }
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

    <!--end col-->

  </div>

  <div class="card shadow mb-4 show-user px-5">
    <div class="card-body">
      @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($admin->id)  @endphp

      <div class="row">
        <div class="col-lg-6 col-md-12 d-flex customer-det alig">
          <h4>Admin Details</h4>
          <p><a class="ml-4" href="{{ route('admin.subadmins.list') }}">
              < Back to Details</a>
          </p>
        </div>
        <div class="col-lg-6 col-md-12 customer-edit text-end">
          <p><a href="{{ route('admin.subadmins.edit', $encrypted) }}">EDIT <i class='fas fa-pencil-alt'></i>
            </a></p>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 p-0">
        <div class="row mx-0 mb-1">
          <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6> Name</h6>
            </div>
            <div class="col-12 detail-type">
              <h4>{{ isset($admin->name) ? $admin->name : '' }}
              </h4>
            </div>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6>Email</h6>
            </div>
            <div class="col-12 detail-type">
              <h4>{{ isset($admin->email) ? $admin->email : '' }}
              </h4>
            </div>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6>Role</h6>
            </div>
            <div class="col-12 detail-type">
              <h4>{{ isset($admin->role) ? $admin->role : '' }}
              </h4>
            </div>
          </div>
        </div>
        <div class="row mx-0 mb-1">
          <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6>Current Image</h6>
            </div>
            <div class="col-12 detail-type">
              <div class="w-100">
                @if (isset($admin->image) && !empty($admin->image))
                  <img alt="Admin Photo" width="40px" height="40px" id="current_Image"
                    class="img-profile rounded-circle"
                    src="{{ asset('public' . \Illuminate\Support\Facades\Storage::url($admin->image)) }}"
                    alt="amherst">
                @else
                  <img class="img-profile rounded-circle"
                    src="{{ asset('public/assets/backend/img/placeholder.jpg') }}" alt="amherst">
                @endif
              </div>
            </div>
          </div>
          {{-- <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6>Password</h6>
            </div>
            <div class="col-12 detail-type">
              <h4>{{ isset($admin->password) ? $admin->password : '' }}
              </h4>
            </div>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="col-12 info-type">
              <h6>Confirm Password</h6>
            </div>
            <div class="col-12 detail-type">
              <h4>{{ isset($admin->cpassword) ? $admin->cpassword : '' }}
              </h4>
            </div>
          </div>
        </div> --}}

        <hr class="dash">

      </div>
    </div>
  </div>
@endsection

@section('script')
  @include('flashy::message')

  <script></script>
@endsection
