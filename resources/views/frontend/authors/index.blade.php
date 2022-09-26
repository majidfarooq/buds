@extends('frontend.layouts.app')

@section('style')
@endsection

@section('title'){{(isset($author->name) ? $author->name : '')}}@endsection
@section('description'){{(isset($data['page']['meta_description']) ? $data['page']['meta_description'] : '')}}@endsection
@section('keywords'){{(isset($author->post_title) ? $author->post_title : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')

    <!-- Page Header-->
    <header class="masthead" style="background-image: url('{{ asset('/public/storage/placeholder.jpg') }}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading text-uppercase">{!! isset($data['page']['banner_content']) ? $data['page']['banner_content'] : '' !!}</div>
                </div>
            </div>
        </div>
    </header>

    @isset($data['pageContent'])
        {!! isset($data['pageContent']) ? $data['pageContent'] : '' !!}
    @endisset

        @if (isset($data['posts']) && count($data['posts']) > 0)
        <div class="container mb-4">

            <div class="row">
                <div class="col-12">
                    <h2 class="my-4">Recent Posts</h2>
                </div>
            </div>

            <article class="entry row">
                @foreach($data['posts'] as $post)
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
                        <span>View All</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
        @endif

@endsection

@section('script')

    @include('flashy::message')

    <script></script>

@endsection

