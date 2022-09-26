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
            <h1 class="h3 mb-0 text-gray-800">Create New Category</h1>
            <a href="{{route('admin.categories.index')}}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
        </div>

        <!-- Content Column -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">New Category</h6>
            </div>
            <div class="card-body">
                <div class="col-12 p-0">

                    <div class="row m-0">
                        {!! Form::open(["route" => ["admin.categories.store"],"files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input autocomplete="name" autofocus
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" type="text">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          id="description" cols="30" rows="10"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input autocomplete="image" autofocus class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" type="file" accept="image/*">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="parent_id">Parent Category</label>--}}
{{--                                <select name="parent_id" id="parent_id" class="form-control">--}}
{{--                                    @if (isset($categories))--}}
{{--                                        <option hidden value="">Select</option>--}}
{{--                                        @foreach($categories as $cat)--}}
{{--                                            <option value="{{$cat->id}}">{{$cat->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    @else--}}
{{--                                        <option hidden>None</option>--}}
{{--                                    @endif--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="btn btn-primary" id="submit" type="submit" value="Create Category">
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

@endsection

