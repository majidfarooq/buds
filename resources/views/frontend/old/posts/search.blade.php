@extends('frontend.layouts.app')

@section('style')
@endsection

@section('title'){{ "Search" }}@endsection
@section('description'){{ "Search results" }}@endsection
@section('keywords'){{(isset($data['page']['meta_keyword']) ? $data['page']['meta_keyword'] : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')

    <!-- Page Header-->
    <header class="masthead" style="background-image: url('{{ isset($data['page']['banner']) ? asset($data['page']['banner']) : '' }}')">

        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        {!! isset($data['page']['banner_content']) ? $data['page']['banner_content'] : '' !!}
                        <h1>SEARCH RESULTS</h1>
                        <span class="subheading">{{ "We found ".$posts->count ." results for ". "“".$posts->title."”"  }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @isset($posts)
        <div class="container-fluid mb-4">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-4">SEARCH RESULTS</h2>
                </div>
            </div>
            <article class="entry row">
                @foreach($posts as $post)
                    <div class="col-lg-4 post-box">
                        <div class="post-img">
                            <img class="img-fluid" src="{{ (isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg')) }}"
                                 alt="{{(isset($post->title) ? Illuminate\Support\Str::limit($post->title, 150) : '')}}">
                        </div>
                        <a href="#">{{ (isset($post->admin->name) ? $post->admin->name : '') }}</a>
                        <span class="my-4 post-date">{{(isset($post->created_at) ? $post->created_at->format('M d Y') : '')}}</span>
                        <h3 class="post-title">{{(isset($post->title) ? Illuminate\Support\Str::limit($post->title, 150) : '')}}</h3>
                        <a href="{{route('blog.show', $post->slug)}}"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                @endforeach
            </article>
            <div class="row">
                <div class="col-12 text-center mt-5 mb-3">
                    <a href="{{route('blogs.index')}}">
                        <span>View All Posts</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endisset


@endsection

@section('script')

    @include('flashy::message')

    <script></script>

@endsection

