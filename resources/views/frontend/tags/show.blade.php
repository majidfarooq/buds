@extends('frontend.layouts.app')
@section('style')
@endsection

@section('title'){{(isset($post->meta_title) ? $post->meta_title : '')}}@endsection
@section('description'){{(isset($post->meta_description) ? $post->meta_description : '')}}@endsection
@section('keywords'){{(isset($post->meta_keyword) ? $post->meta_keyword : '')}}@endsection
@section('content')

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('blogs.index')}}">Blog</a></li>
                    <li>{{ (isset($category->name) ? $category->name : '') }}</li>
                </ol>
                <h2>{{ (isset($category->name) ? $category->name : '') }}</h2>

            </div>
        </section><!-- End Breadcrumbs -->


        <!-- ======= Blog Single Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-8 entries">

                        <article class="entry entry-single">

                            <div class="entry-img">
                                <img class="img-fluid" src="{{(isset($post->thumbnail) ? asset('storage/app/public/posts/' . $post->thumbnail) : asset('public/storage/dummy.jpg'))}}">
                            </div>

                            <h2 class="entry-title">{{ (isset($post->title) ? $post->title : '') }}</h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-single.html">{{ (isset($post->admin->name) ? $post->admin->name : '') }}</a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-single.html"><time datetime="{{ (isset($post->created_at) ? $post->created_at : '') }}">{{ (isset($post->created_at) ? $post->created_at->format('M d Y') : '') }}</time></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-single.html">12 Comments</a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                {!! (isset($post->content) ? $post->content : '') !!}
                            </div>

                            <div class="entry-footer">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                    <li><a href="#">Business</a></li>
                                </ul>

                                <i class="bi bi-tags"></i>
                                <ul class="tags">
                                    <li><a href="#">Creative</a></li>
                                    <li><a href="#">Tips</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </div>

                        </article><!-- End blog entry -->
                        <div class="blog-author d-flex align-items-center">
                            {{--                            <img src="assets/img/blog/blog-author.jpg" class="rounded-circle float-left" alt="">--}}
                            <img class="rounded-circle float-left" src="{{(isset($post->image) ? asset('storage/app/public/posts/' . $post->image) : asset('public/storage/user/dummy.png'))}}">
                            <div>
                                <h4>{{ (isset($post->admin->name) ? $post->admin->name : '') }}</h4>
                                <div class="social-links">
                                    <a href="{{ (isset($post->admin->twitter_url) ? $post->admin->twitter_url : '/') }}"><i class="bi bi-twitter"></i></a>
                                    <a href="{{ (isset($post->admin->facebook_url) ? $post->admin->facebook_url : '/') }}"><i class="bi bi-facebook"></i></a>
                                    <a href="{{ (isset($post->admin->instagram_url) ? $post->admin->instagram_url : '/') }}"><i class="biu bi-instagram"></i></a>
                                </div>
                                <p>{{ (isset($post->admin->about) ? $post->admin->about : 'about') }}</p>
                            </div>
                        </div><!-- End blog author bio -->

                    </div><!-- End blog entries list -->

                    <div class="col-lg-4">

                        <div class="sidebar">

                            <h3 class="sidebar-title">Search</h3>
                            <div class="sidebar-item search-form">
                                <form action="">
                                    <input type="text">
                                    <button type="submit"><i class="bi bi-search"></i></button>
                                </form>
                            </div><!-- End sidebar search formn-->

                            <h3 class="sidebar-title">Categories</h3>
                            <div class="sidebar-item categories">
                                <ul>
                                    <li><a href="#">General <span>(25)</span></a></li>
                                    <li><a href="#">Lifestyle <span>(12)</span></a></li>
                                    <li><a href="#">Travel <span>(5)</span></a></li>
                                    <li><a href="#">Design <span>(22)</span></a></li>
                                    <li><a href="#">Creative <span>(8)</span></a></li>
                                    <li><a href="#">Educaion <span>(14)</span></a></li>
                                </ul>
                            </div><!-- End sidebar categories-->

                            <h3 class="sidebar-title">Recent Posts</h3>
                            <div class="sidebar-item recent-posts">
                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-1.jpg" alt="">
                                    <h4><a href="blog-single.html">Nihil blanditiis at in nihil autem</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-2.jpg" alt="">
                                    <h4><a href="blog-single.html">Quidem autem et impedit</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-3.jpg" alt="">
                                    <h4><a href="blog-single.html">Id quia et et ut maxime similique occaecati ut</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-4.jpg" alt="">
                                    <h4><a href="blog-single.html">Laborum corporis quo dara net para</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-5.jpg" alt="">
                                    <h4><a href="blog-single.html">Et dolores corrupti quae illo quod dolor</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                            </div><!-- End sidebar recent posts-->

                            <h3 class="sidebar-title">Tags</h3>
                            <div class="sidebar-item tags">
                                <ul>
                                    <li><a href="#">App</a></li>
                                    <li><a href="#">IT</a></li>
                                    <li><a href="#">Business</a></li>
                                    <li><a href="#">Mac</a></li>
                                    <li><a href="#">Design</a></li>
                                    <li><a href="#">Office</a></li>
                                    <li><a href="#">Creative</a></li>
                                    <li><a href="#">Studio</a></li>
                                    <li><a href="#">Smart</a></li>
                                    <li><a href="#">Tips</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </div><!-- End sidebar tags-->

                        </div><!-- End sidebar -->

                    </div><!-- End blog sidebar -->

                </div>

            </div>
        </section><!-- End Blog Single Section -->

    </main><!-- End #main -->

@endsection

@section('script')

    @include('flashy::message')

    <script></script>

@endsection


