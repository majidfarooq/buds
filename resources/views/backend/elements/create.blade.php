@extends('backend.layouts.app')

@section('style')

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

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Element</h1>
      <a href="{{route('admin.elements.index')}}"
         class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
    </div>

    <!-- Content Column -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">New Element</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <form action="{{ route('admin.element.store') }}" id="storeElement" method="post">
              @csrf
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" value="{{old('title')}}">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="typeSelector">Type</label>
                <select class="form-control @error('type') is-invalid @enderror" id="typeSelector" name="type">
                  <option value="" {{ (old('type') == null) ? "selected" : '' }} selected>None</option>
                  <option value="parent" {{ (old('type') == 'parent') ? "selected" : '' }}>Parent</option>
                  <option value="daughter" {{ (old('type') == 'daughter') ? "selected" : '' }}>Daughter</option>
                </select>
                @error('type')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="form-group" id="thisSelect" class="type" style="display: none">
                <label for="parentId">Select Parent</label>
                <select class="form-control @error('parentId') is-invalid @enderror" id="parentId" name="parentId">
                  @if($parents->count() > 0)
                    @foreach($parents  as $parent)
                      <option value="{{$parent->id}}">{{$parent->title}}</option>
                    @endforeach
                  @else
                    <option value="" {{ (old('parentId') == null) ? "selected" : '' }} selected>No parent found</option>
                  @endif
                </select>
                @error('parentId')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="template">Template</label>
                <textarea class="form-control @error('template') is-invalid @enderror" cols="10" id="template" name="template" rows="10">{{old('template')}}</textarea>
                @error('template')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <input class="btn btn-primary" id="submit" type="submit" value="Create Element">
              </div>
            </form>
          </div>
          <div class="col-6">
            <p>Save the element first and element fields</p>
            <a title="Add New field" class="btn btn-primary disabled" role="button"><i class="fas fa-plus"></i> Add New
              field</a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

  @include('flashy::message')

  <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}" type="application/javascript"></script>
  <script src="{{ asset('public/assets/backend/js/additional-methods.min.js') }}" type="application/javascript"></script>
  <script type="application/javascript">
      $("#storeElement").validate({
          errorClass: "ui-state-error",
          rules: {
              "title": {
                  required: true,
              },
              "template": {
                  required: true,
              },
          },
          messages: {
              title: {
                  required: "Please enter Element Title",
              },
              template: {
                  required: "Please enter Element Template",
              },
          },
          submitHandler: function (form) {
              return true;
          }
      });
      $('#typeSelector').on('change', function () {
          var value = $(this).val();
          if (value === 'daughter') {
              // $('#'+value).show
              $('#thisSelect').show();
          } else {
              $('#thisSelect').hide();
          }
      });
  </script>
@endsection

