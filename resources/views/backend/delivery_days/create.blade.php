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
  <div class="card h-100 customer_create_form">
    <div class="card-body">
      <div class="col-lg-12 col-md-12">
    <h1>Create a Delivery</h1>
      </div>
    <div class="col-12 p-0">
        {!! Form::open(["route" => ["admin.delivery_days.store"],"id"=>"create_delivery", "files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
    <div class="row">
      <div class="col-lg-6 col-md-12 customer_info mb-5">
          <div class="col-lg-12 col-md-12 form-group  date input-group">
              <label for="delivery_date" class="label w-100">Delivery Date</label>
              <input type="text" placeholder="Choose Date" class="datepicker form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date">
              @error('delivery_date') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
          </div>
          <div class="col-lg-12 col-md-12 d-flex align-items-center my-5">
              <div class="form-group checkbox mr-5">
                  <input type="checkbox" name="thursday" id="thursday" value="thursday">
                  <label for="thursday">Regular</label>
              </div>
              @error('thursday') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
              <div class="form-group checkbox mr-5">
                  <input type="checkbox" name="friday" id="friday" value="friday">
                  <label for="friday">Custom</label>
              </div>
              @error('friday') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
          </div>
      </div>
    </div>
    <div class="row">
    <div class="col-lg-4 col-md-12 text-end cancel-btn"> <a class="back" href="{{ route('admin.delivery_days.index') }}">Cancel</a> </div>
        <div class="col-lg-4 col-md-12 form-group">
            <input class="btn btn-primary btn-block" id="submit" name="submit" required type="submit" value="Create">
        </div>
        </div>
    </div>
      {!! Form::close() !!}
    </div></div>
  </div>
  @endsection
  @section('script')
  @include('flashy::message')
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&key=AIzaSyDreHlutBDFUYo5I-M6N77YcgdgX-kdZ-0"></script>
  <script src="{{ asset('public/assets/backend/js/customer.js') }}"></script>
    <script>
        // $("#create_delivery").validate({
        //     rules: {
        //         "delivery_date": {
        //             required: true,
        //         },
        //         "status": {
        //             required: true,
        //         }
        //     },
        //
        //     submitHandler: function(form) {
        //         return true;
        //     }
        // });
    </script>
  <script type="text/javascript">
      $(function () {
          $('.datepicker').datepicker({
              daysOfWeekDisabled: "4,5",
              language: "es",
              autoclose: true,
              format: "dd/mm/yyyy",
              todayHighlight: true,
              buttonText: "<i class='fa fa-calendar'></i>",
              showOn: "both",
          }).datepicker("setDate", "0");
      });
      $('#create_delivery').submit(function() {
          if ($('input:checkbox', this).length == $('input:checked', this).length ) {
          } else {
              alert('Please tick checkboxe!');
              return false;
          }
      });
  </script>
  @endsection
