@extends('frontend.layouts.app')
@section('style')
@endsection

@section('content')


    <!-- Page Header-->
    <header class="masthead" style="background-image: url('{{(isset($tag->image) ? asset($tag->image) : asset('/public/storage/placeholder.jpg'))}}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <span class="meta text-white">
                        <a class="text-white" href="{{route('home')}}">Home</a>
                        <small><i class="fas fa-arrow-right"></i></small>
                        <a class="text-white"  href="{{route('blogs.index')}}">Blog</a>
                        <small><i class="fas fa-arrow-right"></i></small>
                        <a class="text-white"  href="{{ (isset($tag->slug) ? route('tag.show',$tag->slug) : '') }}">{{ (isset($tag->name) ? $tag->name : '') }}</a>
                    </span>
                    <div class="text-start site-heading text-uppercase"><h1>{{ (isset($tag->name) ? $tag->name : '') }}</h1></div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <p class="text-center">{{ (isset($tag->description) ? $tag->description : '') }}</p>
            </div>
        </div>
    </div>


    <!-- ======= Blog Section ======= -->
    <div class="container mb-4">
        <div class="row">
            @isset($tag->posts)
                @foreach($tag->posts as $post)
                    <article class="col-lg-4 entry">
                        <div class="entry-img">
                            <img class="img-fluid" src="{{(isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg'))}}" alt="{{ (isset($post->title) ? $post->title : '') }}">
                        </div>
                        <h3 class="entry-title my-3">
                            <a href="{{route('blog.show', $post->slug)}}">{{ (isset($post->title) ? $post->title : '') }}</a>
                        </h3>
                        <div class="entry-meta small text-muted">
                            <a href="#">{{ (isset($post->admin->name) ? $post->admin->name : '') }}</a>
                            <time datetime="{{ (isset($post->created_at) ? $post->created_at : '') }}">{{ (isset($post->created_at) ? $post->created_at->format('M d Y') : '') }}</time>
                        </div>
                        <div class="entry-content">
                            <p class="my-3">{{ strip_tags(\Illuminate\Support\Str::limit($post->content, 200)) }}</p>
                            <div class="read-more">
                                <a href="{{route('blog.show', $post->slug)}}">Read More</a>
                            </div>
                        </div>
                    </article>
                    <!-- End blog entry -->
            @endforeach
        @endisset<!-- End blog entries list -->
        </div>
    </div>
    <!-- End Blog Section -->
@endsection

@section('script')

    @include('flashy::message')

    <script></script>

@endsection


