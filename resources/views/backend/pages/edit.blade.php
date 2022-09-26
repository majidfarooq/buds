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
            <h1 class="h3 mb-0 text-gray-800">New Pages</h1>
            <a href="{{route('admin.pages.index')}}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
        </div>

        <!-- Content Column -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create New Page</h6>
            </div>
            <div class="card-body">
                <div class="col-12 p-0">

                    <div class="row m-0">
                        {!! Form::open(["route" => ["pages.update",$page->slug],"files"=> true,"class"=>"w-100"]) !!}
                        <input type="hidden" value="{{$page->id}}" name="pageId">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input autocomplete="title" autofocus
                                       class="form-control @error('title') is-invalid @enderror" id="title"
                                       value="{{$page->title}}"
                                       name="title" type="text">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text"
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           id="meta_title" name="meta_title">
                                    @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text"
                                           class="form-control @error('meta_keywords') is-invalid @enderror"
                                           id="meta_keywords"
                                           name="meta_keywords">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="password_confirmation">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              name="meta_description" id="meta_description" cols="5"
                                              rows="5"></textarea>
                                    @error('meta_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="is_disabled">Is Disabled</label>
                                <select class="form-control @error('is_disabled') is-invalid @enderror"
                                        name="is_disabled" id="is_disabled">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>

                                @error('banner_image')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="btn btn-primary" id="submit"
                                       type="submit" value="Create Page">
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>


        <!-- Content Column -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Element</h6>
            </div>
            <div class="card-body">
                <div class="row m-0">

                    {!! Form::open(["route" => ["pages.elements"],"class"=>"w-100"]) !!}
                    <input type="hidden" value="{{$page->id}}" name="pageId">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control text-capitalize" name="elements" id="elements">
                                <option value="null" hidden>Select</option>
                                @if(isset($elements))
                                    @foreach($elements as $element)
                                        <option value="{{($element->id)?$element->id:''}}">
                                            {{($element->title)?$element->title:''}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100 text-center">
                                Add New Element
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>

    @if ($page['pageElements'])
        @foreach($page['pageElements'] as $pE)
            @php $fields = $pE->element->fields @endphp
            @foreach($pE['content'] as $content)
                @php $contents = $content @endphp
            @endforeach
        @endforeach
        <!-- Content Column -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Page Elements</h6>
                </div>
                <div class="card-body">
                    <div class="col-12 p-0">
                        <div class="row m-0">
                            <input type="hidden" value="{{$page->id}}" name="pageId">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @foreach($fields as $field)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @if($field['type']=='attachment')
                                                    <label for="file_{{$field['id']}}">{{$field['title']}}</label>
                                                    <input type="file" autofocus
                                                           class="form-control"
                                                           id="file_{{$field['id']}}"
                                                           name="dyn_{{$field['id']}}">
                                                    <label for="content">{{$field['title']}}</label>
                                                @elseif($field['type'] == 'textarea')
                                                    <label for="content">{{$field['title']}}</label>
                                                    <textarea class="form-control editor" id="content"
                                                              name="dyn_{{$field['id']}}"
                                                              rows="10"></textarea>
                                                @elseif($field['type'] == 'text')
                                                    <label for="content">{{$field['title']}}</label>
                                                    <textarea class="form-control" id="content"
                                                              name="dyn_{{$field['id']}}"
                                                              rows="10"></textarea>
                                                @elseif($field['type'] == 'select')
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach


                                    <label for="title">Title</label>
                                    <input autocomplete="title" autofocus
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           value="{{$page->title}}"
                                           name="title" type="text">
                                    @error('title')
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
        @endif

    </div>

@endsection

@section('script')

    @include('flashy::message')

    <script>

        {{--        $(document).on('change', '#elements', function () {--}}
        {{--            var value = ($('option:selected', this).val());--}}
        {{--            // alert(value);--}}
        {{--            if ((value === "attachment")) {--}}
        {{--                $('#newElementModal').find('.modal-body').html(`--}}
        {{--                    {!! Form::open(["route" => "pages.store","files" => true]) !!}--}}
        {{--                <div class="col-md-12">--}}
        {{--                <div class="form-group">--}}
        {{--                <label for="content">Content</label>--}}
        {{--                <textarea class="form-control editor" id="content" name="content" rows="10"></textarea>--}}
        {{--                </div></div>--}}
        {{--{!! Form::close() !!}--}}
        {{--                `);--}}
        {{--            }--}}
        {{--            if ((value === "textarea")) {--}}
        {{--            }--}}
        {{--            if ((value === "text")) {--}}
        {{--            }--}}
        {{--        });--}}

    </script>

{{--    <!-- Tinymce Scripts-->--}}
{{--    <script type="application/javascript" src="{{ asset('assets/backend/tinymce/tinymce.min.js') }}"></script>--}}
{{--    <script type="text/javascript">--}}

{{--        tinymce.init({--}}

{{--            selector: '.editor',--}}

{{--            theme: "simple",--}}

{{--            height: 400,--}}

{{--            forced_root_block: "",--}}

{{--            force_br_newlines: false,--}}

{{--            force_p_newlines: false,--}}

{{--            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",--}}

{{--            relative_urls: false,--}}

{{--            remove_script_host: false,--}}

{{--            convert_urls: false,--}}

{{--            plugins: [--}}

{{--                "advlist autolink lists link image charmap print preview hr anchor pagebreak",--}}

{{--                "searchreplace wordcount visualblocks visualchars code fullscreen",--}}

{{--                "insertdatetime media nonbreaking save table contextmenu directionality",--}}

{{--                "emoticons template paste textcolor colorpicker textpattern"--}}

{{--            ],--}}

{{--        });--}}

{{--    </script>--}}

@endsection

