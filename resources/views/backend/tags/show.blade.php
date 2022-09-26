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

            <!--end card-body-->

            </div>

        </div>

        <!--end col-->

    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tag Details</h1>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tag</h6>
            </div>
            <div class="card-body">
                <div class="col-md-12 col-sm-12 p-0">
                    <div class="row mx-0 mb-1">
                        <div class="col-4 info-type">
                            <h6>Name</h6>
                        </div>
                        <div class="col-8 detail-type">
                            <p>{{ (isset($tag->name ) ? $tag->name : '') }}</p>
                        </div>
                    </div>
                    <div class="row mx-0 mb-1">
                        <div class="col-4 info-type">
                            <h6>Description</h6>
                        </div>
                        <div class="col-8 detail-type">
                            <p>{{ (isset($tag->description) ? $tag->description : '') }}</p>
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

