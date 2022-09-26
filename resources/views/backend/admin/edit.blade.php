@extends('backend.layouts.app')

@section('style')
@endsection

@section('content')
  <div class="card shadow shadow mb-4">
    <?php $admin = Auth::guard('admin')->user(); ?>

    @if ($message = \Illuminate\Support\Facades\Session::get('error'))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
      </div>
    @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
      <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <div class=" mb-4 h-100">
      <div class="card-body">
        <h4>Edit Admin</h4>
        <div class="col-12 p-0">
          {!! Form::open([
            'route' => 'admin.subadmins.update',
            'id' => 'registerAdmin',
            'autocomplete' => 'off',
            'files' => true,
          ]) !!}
          <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="name">Name</label>
                <input autocomplete="name"
                  @if (isset($adminDetail->name)) value="{{ $adminDetail->name }}" @endif
                  class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                  type="text">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            @if (isset($adminDetail))
              <input type="hidden" name="admin_id" value="{{ $adminDetail->id }}">
            @endif

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="name">Email</label>
                <input autocomplete="name" placeholder="email" required autofocus
                  class="form-control @error('name') is-invalid @enderror" id="email" name="email"
                  type="email" value="{{ $adminDetail->email }}">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="name">Role</label>
                <select class="form-control" id="role" name="role" required>
                  <option value="">Select</option>
                  <option @if ($adminDetail->role == 'super_admin') selected @endif value="super_admin">Admin
                  </option>
                  <option @if ($adminDetail->role == 'manager') selected @endif value="manager">Sub Admin
                  </option>
                  {{-- <option @if ($adminDetail->role == 'reviewer') selected @endif value="reviewer">
                    Reviewer</option> --}}
                </select>
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="current_Image">Current Image</label>
                <div class="w-100">
                  @if (isset($adminDetail->image) && !empty($adminDetail->image))
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
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <div class="image box">
                  <label for="image">Change Image</label>
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
            {{-- <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="extension">Extension</label>
                <input autocomplete="extension"
                  @if (isset($adminDetail->extension)) value="{{ $adminDetail->extension }}" @endif
                  autofocus required class="form-control @error('extension') is-invalid @enderror"
                  id="extension" name="extension" type="text">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div> --}}
            {{-- <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="name">Password</label>
                <input autocomplete="off" autofocus required
                  class="form-control @error('name') is-invalid @enderror" id="password" name="password"
                  type="password">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div> --}}

          </div>

          {{-- <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label for="name">Confirm Password</label>
                <input autocomplete="name" autocomplete="off" autofocus required
                  class="form-control @error('name') is-invalid @enderror" id="cpassword"
                  name="cpassword" type="password">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
          </div> --}}

          <div class="row my-5">
            <div class="col-lg-4 col-md-12 text-end">
              <a class="back" href="#">Cancel</a>
            </div>
            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <div class="form-group">
                  <input class="btn btn-primary w-100" id="submit" name="submit" required
                    type="submit" value="Update">
                </div>
              </div>
            </div>
          </div>

          {!! Form::close() !!}
        </div>

      </div>
    </div>
  </div>
@endsection

@section('script')
  @include('flashy::message')

  <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('public/assets/backend/js/additional-methods.min.js') }}"></script>


  <script>
    $("#registerAdmin").validate({
      rules: {
        "name": {
          required: true,
        },
        "email": {
          required: true,
        },
        "role": {
          required: true,
        },
        "password": {
          required: true,
          minlength: 6
        },
        "cpassword": {
          required: true,
          equalTo: "#password",
          minlength: 6,
        }
      },
      messages: {
        "name": {
          required: "this field can not be empty",
        },
        "email": {
          required: "this field can not be empty",
        },
        "role": {
          required: "this field can not be empty",
        },
        "password": {
          required: "Please, enter an password",
          password: "Password Must contain 6 characters.",
        },
        "cpassword": {
          required: "Please, enter an password",
          confirm_password: "Password Must contain 6 characters.",
          equalTo: "Please enter the same password as above"
        }
      },
      submitHandler: function(form) {
        return true;
      }
    });
  </script>
@endsection
