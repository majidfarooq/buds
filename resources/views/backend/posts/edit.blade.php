@extends('backend.layouts.app')

@section('style')

    <style>
        .tags-selector input {
            display: none !important;
        }

        .tags-selector input[type=checkbox] + label {
            display: inline-block;
            border-radius: 6px;
            background: #dddddd;
            height: 40px;
            width: fit-content;
            padding: 0px 15px;
            margin-right: 3px;
            line-height: 40px;
            text-align: center;
            cursor: pointer;
        }

        .tags-selector input[type=checkbox]:checked + label {
            background: #4e73df;
            color: #ffffff;
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
            <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
            <a href="{{route('admin.posts.index')}}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
        </div>

        <!-- Content Column -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
            </div>
            <div class="card-body">
                <div class="col-12 p-0">

                    <div class="row m-0">
                        {!! Form::open(["route" => ["admin.posts.update"],"id"=>"editPost","files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
                        <input type="hidden" value="{{$post->id}}" name="postId" id="postId">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input autocomplete="name" autofocus
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" type="text"
                                       value="{{(isset($post->title)?$post->title:'')}}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" value="{{(isset($post->meta_title)?$post->meta_title:'')}}"
                                       class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                       name="meta_title">
                                @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" value="{{(isset($post->meta_keyword)?$post->meta_keyword:'')}}"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       id="meta_keywords" name="meta_keywords">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password_confirmation">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          name="meta_description" id="meta_description" cols="2"
                                          rows="2">{{(isset($post->meta_description)?$post->meta_description:'')}}</textarea>
                                @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="text_content">Content</label>
                                <textarea name="text_content"
                                          class="form-control editor @error('text_content') is-invalid @enderror"
                                          id="text_content" cols="30"
                                          rows="10">{{(isset($post->content)?$post->content:'')}}</textarea>
                                @error('text_content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_image">Current Image</label>
                                <div class="w-100">
                                    <img width="100"
                                         src="{{(isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg'))}}"
                                         alt="current image"
                                         id="category_image">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input autocomplete="thumbnail" autofocus
                                       class="form-control @error('thumbnail') is-invalid @enderror"
                                       id="thumbnail" name="thumbnail" type="file" accept="thumbnail/*">
                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}"
                                        @isset($post->category) {{ $post->category->id === $cat->id ? 'selected' : '' }}@endisset> {{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- @php $array = explode(',', $post_tags); @endphp--}}
                        @isset($tags)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tags">Select Tags</label>
                                    <div class="tags-selector">
                                        @foreach($tags as $tag)
                                            <input type="checkbox" id="tag-{{$tag->name}}" value="{{$tag->name}}" class="tags"/>
                                            <label for="tag-{{$tag->name}}">{{$tag->name}}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endisset


                        <input type="hidden" value="{{ isset($post_tags) ? $post_tags : '' }}" name="tags" id="tags">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="btn btn-primary" id="submit" type="submit" value="Update Post">
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

    <!-- Tinymce Scripts-->
    <script type="application/javascript" src="{{ asset('public/assets/backend/tinymce/tinymce.min.js') }}"></script>

    <script type="text/javascript">

        tinymce.init({

            selector: '.editor',

            theme: "silver",

            height: 400,

            forced_root_block: "",

            force_br_newlines: false,

            force_p_newlines: false,

            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",

            relative_urls: false,

            remove_script_host: false,

            convert_urls: false,

            plugins: [

                "advlist autolink lists link image charmap print preview hr anchor pagebreak",

                "searchreplace wordcount visualblocks visualchars code fullscreen",

                "insertdatetime media nonbreaking save table contextmenu directionality",

                "emoticons template paste textcolor colorpicker textpattern"

            ],

        });

    </script>

    <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}"
            type="application/javascript"></script>
    <script src="{{ asset('public/assets/backend/js/additional-methods.min.js') }}"
            type="application/javascript"></script>

    <script type="application/javascript">
        $("#editPost").validate({
            rules: {
                "title": {
                    required: true,
                },
                "meta_title": {
                    required: true,
                },
                "meta_keywords": {
                    required: true,
                },
                "meta_description": {
                    required: true,
                },
                "text_content": {
                    required: true,
                },
            },
            submitHandler: function (form) {
                tags();
                return true;
            }
        });


        function tags() {
            var tag = [];
            $(".tags").each(function () {
                tag.push($(this).val());
            });

            var tags = tag.join();
            $("#tags").val(tags);
            $("#tag").val(tag);
        }

    </script>

@endsection

