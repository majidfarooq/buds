@extends('backend.layouts.app')

@section('style')

@endsection

@section('content')

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-white">Settings</h1>
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
    <?php $admin = Auth::guard('admin')->user() ?>
    <!-- Content Row -->
      <div class="row mt-4 setting-section">
        <!-- Content Column -->
          <div class="col-lg-12 mb-4">
              <div class="card shadow mb-4 h-100">
                  <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Stripe</h6>
                  </div>
                  <div class="card-body">
                      <div class="col-12 p-0">
                          {!! Form::open(['route' => "admin.accounts.updateSettings",'files' => true]) !!}
                          @foreach ($siteContents as $field )
                            <div class="form-group">
                              <label for="public_key_live">{{str_replace('_', ' ', $field['field_key'])}}</label>
                              <input class="form-control @error($field['field_key']) is-invalid @enderror" id="{{$field['field_key']}}"
                                     name="{{$field['field_key']}}" type="text" value="{{$field['field_value'] }}">
                              @error($field['field_key'])
                              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                              @enderror
                          </div>

                          @endforeach
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

@endsection

@section('script')

  @include('flashy::message')

  <script>

  </script>

@endsection

