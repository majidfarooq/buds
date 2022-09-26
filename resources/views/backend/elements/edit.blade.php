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
            <h1 class="h3 mb-0 text-gray-800">Update Element</h1>
            <a href="{{route('admin.elements.index')}}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
        </div>

        <!-- Content Column -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Element</h6>
            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-6">
                        <form action="{{ route('admin.element.update') }}" id="storeElement" method="post">
                            @csrf
                            <input type="hidden" name="elementId" id="elementId" value="{{($element->id) ? $element->id : ''}}">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" value="{{old('title', ($element->title)? $element->title : '')}}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                            {{--<div class="form-group">
                              <label for="type">Type</label>
                              <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="" {{ (old('type',$element->type) == null) ? "selected" : '' }} selected>None</option>
                                <option value="parent" {{ (old('type',$element->type) == 'parent') ? "selected" : '' }}>Parent</option>
                                <option value="daughter" {{ (old('type',$element->type) == 'daughter') ? "selected" : '' }}>Daughter</option>
                              </select>
                              @error('type')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>--}}

                            <div class="form-group">
                                <label for="typeSelector">Type</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="typeSelector" name="type">
                                    <option value="" {{ (old('type',$element->type) == null) ? "selected" : '' }} selected>
                                        None
                                    </option>
                                    <option value="parent" {{ (old('type',$element->type) == 'parent') ? "selected" : '' }}>
                                        Parent
                                    </option>
                                    <option value="daughter" {{ (old('type',$element->type) == 'daughter') ? "selected" : '' }}>
                                        Daughter
                                    </option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                            <div class="form-group" id="thisSelect" class="type"
                                 style="@if ($element->type == "daughter") {{'display:block'}} @else {{'display:none'}} @endif">
                                <label for="parentId">Select Parent</label>
                                <select class="form-control @error('parentId') is-invalid @enderror" id="parentId" name="parentId">
                                    @if ($element->parent_element)
                                        <option value="{{$element->parent_element->id}}">{{$element->parent_element->title}}</option>
                                    @else
                                        <option value="" {{ (old('parentId') == null) ? "selected" : '' }} selected>No
                                            parent found
                                        </option>
                                        @foreach($parents  as $parent)
                                            <option value="{{$parent->id}}">{{$parent->title}}</option>
                                        @endforeach
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
                                <textarea class="form-control @error('template') is-invalid @enderror" cols="10" id="template" name="template" rows="10">{{old('template', ($element->template)? $element->template : '')}}</textarea>
                                @error('template')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" id="submit" type="submit" value="Update Element">
                            </div>
                        </form>
                    </div>
                    <div class="col-6">

                        <a aria-controls="addNewField" aria-expanded="false" class="btn btn-primary"
                           data-toggle="collapse" href="#addNewField" role="button"
                           title="Add New field"><i class="fas fa-plus"></i> Add New field</a>

                        <div class="collapse my-2" id="addNewField">
                            <div class="card card-body">
                                <form id="newField" data-elementId="{{($element->id) ? $element->id : ''}}"
                                        {{--                      onsubmit="storeField(this)" method="POST" enctype="multipart/form-data"--}}
                                >
                                    <input type="hidden" name="element_id" value="{{($element->id) ? $element->id : ''}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field_title">Title</label>
                                                <input type="text" class="form-control" id="field_title" name="field_title" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field_type">Type</label>
                                                <select class="form-control" id="field_type" name="field_type" onchange="changeInputType(this)">
                                                    @foreach($fields as $field)
                                                        <option value="{{$field}}">{{$field}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group fieldValue">
                                                <label for="field_value">Value</label>
                                                <input type="file" class="form-control" id="field_value" name="field_value" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Add New field</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="fields" id="fields"></div>
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
        setTimeout(function () {
            getElementField();
        }, 1000);
        function removeLoader() {
            $("#loadingDiv").fadeOut(500, function () {
                $("#loadingDiv").remove();
            });
        }

        function runLoader() {
            $('body').append('<div id="loadingDiv" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
        }

        function changeInputType(elem) {
            var name = $(elem).attr('name');
            var parent = $(elem).closest('.row');
            var fieldDiv = parent.find(".fieldValue");
            if (elem.value === 'attachment') {
                fieldDiv.html("<input class='form-control' id='field_value' name='field_value' required type='file' value=''>")
            } else {
                fieldDiv.html("<input class='form-control' id='field_value' name='field_value' required type='text' value='Enter Text'>")
            }
        }
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
        $("#newField").validate({
            errorClass: "ui-state-error",
            rules: {
                "field_title": {
                    required: true,
                },
                "field_type": {
                    required: true,
                },
                "field_value": {
                    required: true,
                },
            },
            messages: {
                field_title: {
                    required: "Please enter field Title",
                },
                field_type: {
                    required: "Please select field type",
                },
                field_value: {
                    required: "field is required",
                },
            },
            submitHandler: function (form) {
                storeField(form)
                return false;
            }
        });
        function storeField(elem) {
            var id = $(elem).attr("id");
            let formData = new FormData(elem);
            $.ajax({
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                type: 'post',
                url: "{{ URL::route('admin.field.create') }}",
                beforeSend: function () {
                    runLoader();
                },
                success: function (data) {
                    if (data.success) {
                        removeLoader();
                        document.getElementById('newField').reset();
                        $('#addNewField').removeClass('show');
                        success(data.success);
                        getElementField();
                    } else {
                        fail(data);
                    }
                }
            });
        }
        function deleteField(elem) {
            var id = $(elem).data("id");
            $.ajax({
                url: "{{ URL::route('admin.field.delete') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                beforeSend: function () {
                    runLoader();
                },
                success: function (data) {
                    if (data.success) {
                        removeLoader();
                        getElementField();
                    } else {
                        fail(data);
                    }
                }
            });
        }
        function checkUpdateField(elem) {
            var formId = $(elem).data("id");
            $("#"+formId).validate({
                errorClass: "ui-state-error",
                submitHandler: function (form) {
                    updateField(form);
                    return false;
                }
            });
        }
        function updateField(elem) {
            let formData = new FormData(elem);
            $.ajax({
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                type: 'post',
                url: "{{ URL::route('admin.field.update') }}",
                beforeSend: function () {
                    runLoader();
                },
                success: function (data) {
                    if (data.success) {
                        removeLoader();
                        getElementField();
                    } else {
                        fail(data);
                    }
                }
            });

        }
        function getElementField() {
            var elementId = $('#elementId').val();
            $.ajax({
                url: "{{ URL::route('admin.field.get') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    elementId: elementId,
                },
                success: function (data) {
                    if (data.success) {
                        $('#fields').html(data.success);
                    } else {
                        fail(data);
                    }

                }
            });
        }
        function success(data) {
            $('.messages').html('<div class="alert alert-success mt-4 mb-4 p-2">' +
                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                '<strong>' + data + '</strong>' +
                '</div>');
        }
        function fail(data) {
            $('.messages').html('<div class="alert alert-danger mt-4 mb-4 p-2">' +
                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                '<strong>' + data + '</strong>' +
                '</div>');
        }
    </script>
@endsection

