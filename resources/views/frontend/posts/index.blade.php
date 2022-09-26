@extends('frontend.layouts.app')
@section('style')
@endsection

@section('type'){{ 'WebPage' }}@endsection
@section('title'){{ 'Our Blog' }}@endsection
@section('description'){{ 'Our Blog Description' }}@endsection
@section('keywords'){{ 'Our Blog Keywords' }}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('robots'){{ 'index,follow' }}@endsection

@section('content')
    <!-- Page Header-->

    <header class="masthead" style="background-image: url('{{ asset('/public/storage/placeholder.jpg') }}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading text-uppercase"><h1>our blog</h1></div>
                </div>
            </div>
        </div>
    </header>

    <!-- ======= Blog Section ======= -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-lg-8 entries">
                @isset($posts)
                    @foreach($posts as $post)
                        <div class="card mb-4">
                            <article class="entry mb-4">
                                <a href="{{route('blog.show', $post->slug)}}">
                                    <img class="card-img-top img-fluid"
                                         src="{{(isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg'))}}">
                                </a>
                                <div class="card-body">
                                    <div class="small text-muted">
                                        <a href="{{route('author.index', $post->admin->name)}}">{{ (isset($post->admin->name) ? $post->admin->name : '') }}</a>
                                        <time
                                            datetime="{{ (isset($post->created_at) ? $post->created_at : '') }}">{{ (isset($post->created_at) ? $post->created_at->format('M d Y') : '') }}</time>
                                    </div>
                                    <h2 class="card-title">{{ (isset($post->title) ? $post->title : '') }}</h2>
                                    <p class="card-text">{{ strip_tags(\Illuminate\Support\Str::limit($post->content, 200)) }}</p>
                                    <a class="btn btn-primary" href="{{route('blog.show', $post->slug)}}">Read more
                                        →</a>
                                </div>
                            </article>
                        </div><!-- End blog entry -->
                    @endforeach
                @endisset

            </div>
            <!-- End blog entries list -->

            <div class="col-lg-4">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <form action="{{ route('search.index') }}" method="GET">
                            <div class="input-group">
                                <input class="form-control" name="s" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search">
                                <button class="btn btn-primary" type="submit" id="button-search">Go!</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            @isset($categories)
                                @foreach($categories as $category)
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <a href="{{ (isset($category->name) ? route('category.show',$category->slug) : '') }}">{{ (isset($category->name) ? $category->name : '') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
                <!-- Tags widget-->
                <div class="card mb-4">
                    <div class="card-header">Tags</div>
                    <div class="card-body">
                        <div class="row">
                            @isset($tags)
                                @foreach($tags as $tag)
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <a href="{{ (isset($tag->name) ? route('tag.show',$tag->slug) : '') }}">{{ (isset($tag->name) ? $tag->name : '') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to
                        use, and feature the Bootstrap 5 card component!
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- End Blog Section -->

@endsection

@section('script')

    @include('flashy::message')

    <script></script>

@endsection


