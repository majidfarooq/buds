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
  <div class="card h-100 package_edit_form">
    <div class="card-body">
      <div class="col-lg-12 col-md-12">
    <h1>Edit a Package</h1>
      </div>

    <div class="col-12 p-0">
      {!! Form::open(['route' => ['admin.packages.update',$package->slug], 'id' => 'update_package', 'files' => true]) !!}
        <div class="row">
        <div class="col-lg-6 col-md-12 customer_info form_section">
          <div class="row">
          {{-- <div class="col-lg-12 col-md-12">  <h2>  Customer Info </h2> </div> --}}
        <div class="col-lg-6 col-md-12 form-group">
          <input placeholder="Package Title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{(isset($package->title)?$package->title:'')}}" name="title" type="text" required>
          @error('title') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
        </div>
        <div class="col-lg-6 col-md-12 form-group">
          <input placeholder="Package Type" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{(isset($package->type)?$package->type:'')}}"  type="text" required>
          @error('type') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
          <div class="col-lg-6 col-md-12 calculate_amount form-group">
              <label>Product Price</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">$</span>
                  </div>
                  <input placeholder="0.00" class="form-control text-right" id="amount" type="text" name="amount" onkeypress="return isNumberKey(event)" value="{{(isset($package->amount)?$package->amount:'')}}">
              </div>
          </div>

          <div class="col-lg-6 col-md-12 form-group">
              <label> Tax </label>
              <div class="input-group border-input">
                  <input placeholder="0.00" class="form-control calculate_amount text-right @error('tax') is-invalid @enderror" id="tax" name="tax"  value="{{(isset($package->tax)?$package->tax:'')}}" onkeypress="return isNumberKey(event)" type="text">
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
                      <input value="50" class="form-control calculate_amount text-right @error('mark_up') is-invalid @enderror" value="{{(isset($package->mark_up)?$package->mark_up:'')}}" id="mark_up" name="mark_up" onkeypress="return isNumberKey(event)" type="text">
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
                  <input  placeholder="0.00" class="form-control calculate_amount text-right" id="delivery_fee" name="delivery_fee"  value="{{(isset($package->delivery_fee)?$package->delivery_fee:'')}}" onkeypress="return isNumberKey(event)" type="text">
              </div>
          </div>
        <div class="col-lg-6 col-md-12 form-group">
          <label>  Cost Price</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">$</span>
                </div>
                <input  placeholder="0.00" readonly class="form-control text-right @error('price') is-invalid @enderror" id="price" name="price"  value="{{ round($package->price, 2) }}" type="text" onkeypress="return isNumberKey(event)" required>
            </div>
          @error('price') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <div class="col-lg-6 col-md-12 form-group">
            <label> Description </label>
            <textarea placeholder="Description" class="form-control" id="description"  name="description"> {{(isset($package->description)?$package->description:'')}}</textarea>
        </div>
      </div>

    </div>
        <div class="col-lg-6 col-md-12 customer_info form_section">
            <div class="row">
{{--                <div class="col-lg-12 col-md-12 d-flex align-items-center">--}}
{{--                    <div class="form-group checkbox mr-5">--}}
{{--                        <input type="checkbox" name="show_frontend" id="show_frontend" {{ $package->show_frontend == '1' ? 'checked' : '' }}>--}}
{{--                        <label for="show_frontend">Show on frontend</label>--}}
{{--                    </div>--}}
{{--                    @error('show_frontend') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror--}}
{{--                </div>--}}
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                            <div class="w-100">
                            @if (isset($package->image) && !empty($package->image))
                                <img alt="Admin Photo" width="60px" height="60px" id="current_Image"
                                     class="img-profile rounded-circle"
                                     src="{{ asset('public' . \Illuminate\Support\Facades\Storage::url($package->image)) }}"
                                     alt="amherst">
                            @else
                                <img class="img-profile rounded-circle"
                                     src="{{ asset('public/assets/backend/img/placeholder.jpg') }}" alt="amherst">
                            @endif
                            </div>
                </div>
                <div class="form-group">
                    <div class="image box">
                        <label for="image">Banner Image</label>
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
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <div class="w-100">
                        @if (isset($package->thumbnail) && !empty($package->thumbnail))
                            <img alt="Admin Photo" width="60px" height="60px" id="current_Image"
                                 class="img-profile rounded-circle"
                                 src="{{ asset('public' . \Illuminate\Support\Facades\Storage::url($package->thumbnail)) }}"
                                 alt="amherst">
                        @else
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('public/assets/backend/img/placeholder.jpg') }}" alt="amherst">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="image box">
                        <label for="thumbnail">thumbnail Image</label>
                        <input class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail"
                               name="thumbnail" placeholder="thumbnail" type="file">
                        @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
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
    <script>
        $( document ).ready(function() {
            if ($('#amount').val()) {
                var total_price = parseFloat($('#amount').val())
                if (total_price > 0) {
                    // Tax Calculation
                    if ($('#tax').val()) {
                        var tax = parseFloat($('#tax').val())
                    } else {
                        var tax = 0
                    }

                    var price_before_tax = (total_price * 100) / (100 + tax);
                    var tax_amount = total_price - price_before_tax

                    // Markup Calculations
                    if ($('#mark_up').val()) {
                        var mark_up = parseFloat($('#mark_up').val())
                    } else {
                        var mark_up = 0
                    }

                    var markup_amount = price_before_tax * (mark_up / 100);
                    var amount_before_markup = price_before_tax - markup_amount

                    if ($('#delivery_fee').val()) {
                        var delivery_fee = parseFloat($('#delivery_fee').val())
                    } else {
                        var delivery_fee = 0
                    }

                    var price_before_delivery = amount_before_markup - delivery_fee;


                    var price = $('#price').val(parseFloat(price_before_delivery).toFixed(2));
                    $('#tax_amount').html(parseFloat(tax_amount).toFixed(2));
                    $('#mark_up_amount').html(parseFloat(markup_amount).toFixed(2));
                }
            } else {
                var price = 0
        }
        });
    </script>
  @endsection
