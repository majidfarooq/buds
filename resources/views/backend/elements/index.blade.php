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
            <h1 class="h3 mb-0 text-gray-800">Elements</h1>
            <a href="{{route('admin.element.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add New Elements</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Elements</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="elements">
                        <thead>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('#elements').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ URL::route('admin.elements.index') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "title" },
                    { "data": "type" },
                    { "data": "created_at" },
                    { "data": "action", className: "action", colspan: "1", },
                ]

            });
        });
    </script>
    @include('flashy::message')

    <script></script>

@endsection

