@extends('backend.layouts.app')

@section('style')

@endsection

@section('content')

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Settings</h1>
  </div>
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

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="accountSettings-tab" data-toggle="tab" href="#accountSettings" role="tab" aria-controls="accountSettings" aria-selected="true">Account Settings</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="accountSettings" role="tabpanel" aria-labelledby="accountSettings-tab">
    <?php $admin = Auth::guard('admin')->user() ?>

    <!-- Content Row -->
      <div class="row mt-4">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Change Information</h6>
            </div>
            <div class="card-body">
              <div class="col-12 p-0">
                {!! Form::open(['route' => "admin.accounts.information",'files' => true]) !!}
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input autocomplete="name" autofocus
                         class="form-control @error('name') is-invalid @enderror" id="name"
                         name="name" type="text" value="{{$admin->name}}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="current_Image">Current Image</label>
                    <div class="w-100">
                      <img alt="Admin Photo" height="100px" id="current_Image"
                         src="{{ (isset($admin->image) ? asset($admin->image) : asset('/public/storage/images/dummy.jpg')) }}"
                         width="100px">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="image box">
                      <label for="image">Upload Image</label>
                      <input class="form-control @error('image') is-invalid @enderror" id="image"
                           name="image" placeholder="image" type="file">
                      @error('image')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input class="btn btn-primary" id="submit"
                         name="submit" required type="submit" value="Submit">
                  </div>
                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
            </div>
            <div class="card-body">
              <div class="col-12 p-0">
                {!! Form::open(['route' => "admin.accounts.password",'files' => true]) !!}
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="current_password">Enter Current Password</label>
                    <input type="password" required=""
                         class="form-control @error('current_password') is-invalid @enderror"
                         id="current_password" name="current_password">
                    @error('current_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" required=""
                         class="form-control @error('password') is-invalid @enderror"
                         id="password" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="password_confirmation">Re-Type New Password</label>
                    <input type="password" required=""
                         class="form-control @error('password_confirmation') is-invalid @enderror"
                         id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input class="btn btn-primary" id="submit" type="submit" value="Submit">
                  </div>
                </div>
                {!! Form::close() !!}
              </div>
            </div>
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

