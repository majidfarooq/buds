@extends('backend.layouts.app')
@section('style')

@endsection
@section('content')
  <div class="row"><div class="col-12"><div class="card border-0"></div></div></div>
  <div class="card shadow shadow mb-4">
  <?php $admin = Auth::guard('admin')->user(); ?>
  @if ($message = \Illuminate\Support\Facades\Session::get('error'))
    <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
  @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
    <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
  @endif
  <div class="card h-100 package_create_form">
    <div class="card-body">
      <div class="col-lg-12 col-md-12">
    <h1>Create a Package</h1>
      </div>
    <div class="col-12 p-0">
      {!! Form::open(['route' => 'admin.packages.store', 'id' => 'create_package', 'files' => true]) !!}
        <div class="row">
            <div class="col-lg-6 col-md-12 customer_info form_section">
          <div class="row">
          {{-- <div class="col-lg-12 col-md-12">  <h2>  Customer Info </h2> </div> --}}
        <div class="col-lg-6 col-md-12 form-group">
          <input placeholder="Package Title" class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" required autofocus>
          @error('title') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-6 col-md-12 form-group">
          <input placeholder="Package Type" class="form-control @error('type') is-invalid @enderror" id="type" name="type" type="text" required>
          @error('type') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

          <div class="col-lg-6 calculate_amount col-md-12 form-group">
              <label>Product Price</label>
              <div class="input-group">
              <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">$</span>
              </div>
              <input placeholder="0.00" class="form-control text-right" id="amount" name="amount" type="text" onkeypress="return isNumberKey(event)">
              </div>
          </div>
        <div class="col-lg-6 col-md-12 form-group">
          <label> Tax </label>
            <div class="input-group border-input">
                <input  value="8.37" class="form-control calculate_amount text-right @error('tax') is-invalid @enderror" id="tax" name="tax" onkeypress="return isNumberKey(event)" type="text">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">%</span>
                </div>
            </div>
            <div class="d-flex send-data">
                <p class="mt-1 mb-0">Tax Amount <span class="font-weight-bold">$ </span></p>
                <p id="tax_amount" class="mt-1 mb-0 font-weight-bold">0.00</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 form-group">
          <label> Markup </label>
            <div class="input-group border-input">
                <input  value="50" class="form-control calculate_amount text-right @error('mark_up') is-invalid @enderror" id="mark_up" name="mark_up" onkeypress="return isNumberKey(event)" type="text">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">%</span>
                </div>
            </div>
            <div class="d-flex send-data">
                <p class="mt-1 mb-0">Markup Amount <span class="font-weight-bold">$ </span></p>
                <p id="mark_up_amount" class="mt-1 mb-0 font-weight-bold">0.00</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 form-group">
          <label> Delivery Fee </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">$</span>
                </div>
                <input  value="6.00" class="form-control calculate_amount text-right" id="delivery_fee" name="delivery_fee" onkeypress="return isNumberKey(event)" type="text">
            </div>

        </div>
          <div class="col-lg-6 col-md-12 form-group">
              <label> Cost Price </label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">$</span>
                  </div>
                  <input placeholder="0.00" readonly class="form-control  text-right @error('price') is-invalid @enderror" id="price" name="price" type="text" onkeypress="return isNumberKey(event)" required>
              </div>
              @error('price') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
          </div>

        <div class="col-lg-6 col-md-12 form-group">
            <label> Description </label>
            <textarea placeholder="Description" class="form-control" id="description" name="description"></textarea>
        </div>
      </div>
    </div>
            <div class="col-lg-6 col-md-12 customer_info form_section">
                <div class="row">
{{--                    <div class="col-lg-12 col-md-12 d-flex align-items-center">--}}
{{--                        <div class="form-group checkbox mr-5">--}}
{{--                            <input type="checkbox" name="show_frontend" id="show_frontend" value="1">--}}
{{--                            <label for="show_frontend">Show on frontend</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="image box">
                            <label for="image">Banner Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" id="image" name="image" placeholder="image" type="file">
                            @error('image')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <div class="image box">
                            <label for="thumbnail">Thumbnail Image</label>
                            <input class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" placeholder="thumbnail" type="file">
                            @error('thumbnail')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <hr>

    <div class="row my-4">
    <div class="col-lg-4 col-md-12 text-end cancel-btn"> <a class="back" href="{{ route('admin.packages.index') }}">Cancel</a> </div>
    <div class="col-lg-4 col-md-12 form-group"><input class="btn btn-primary btn-block" id="submit" name="submit" required type="submit" value="Submit"></div>
    </div>
      {!! Form::close() !!}
    </div> </div>
  </div>
  @endsection
  @section('script')
  @include('flashy::message')
  <script src="{{ asset('public/assets/backend/js/package.js') }}"></script>
  @endsection
