@extends('frontend.layouts.app')
@section('style')
@endsection

@section('ogType'){{ 'Article' }}@endsection
@section('title'){{(isset($data['post']->meta_title) ? $data['post']->meta_title : $data['post']->title )}}@endsection
@section('description'){{ (isset($data['post']->meta_description) ? $data['post']->meta_description : strip_tags(\Illuminate\Support\Str::limit($data['post']->content, 155))) }}@endsection
@section('keywords'){{(isset($data['post']->meta_keyword) ? $data['post']->meta_keyword : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')




    <!-- page title area  -->
    <section class="page-title-area breadcrumb-spacing"
             data-background="{{ (isset($data['post']->thumbnail) ? asset($data['post']->thumbnail) : asset('/public/storage/placeholder.jpg')) }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-9">
                    <div class="page-title-wrapper text-center">
                        <h3 class="page-title mb-25">Blog Details</h3>
                        <div class="breadcrumb-menu">
                            <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                                <ul class="trail-items">
                                    <li class="trail-item trail-begin"><a href="index.html"><span>Home</span></a></li>
                                    <li class="trail-item trail-end"><span>Blog Details</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page title area end -->

    <!-- blog details area -->
    <section class="blog-details-area  pt-120 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12">
                    <div class="kblog">
                        <div class="kblog-img">
                            <a href="blog-details.html">
                                <img src="{{ (isset($data['post']['thumbnail']) ? asset($data['post']['thumbnail']) : asset('/public/storage/placeholder.jpg')) }}" class="img-fluid" alt="{{(isset($data['post']['title']) ? $data['post']['title'] : '')}}">
                            </a>
                            <span>21 May</span>
                        </div>
                        <div class="kblog-text kblog-text2">
                            <div class="kblog-meta">
                                <a href="blog-details.html"><i class="fal fa-user-circle"></i> by Admin</a>
                                {{--<a href="blog-details.html"><i class="fal fa-comments"></i> 2 Comments</a>--}}
                            </div>
                            <h3 class="kblog-text-title2 mb-40">
                                <a href="blog-details.html">{{(isset($data['post']['title']) ? $data['post']['title'] : '')}}</a>
                            </h3>
                            {!! (isset($data['post']['content']) ? $data['post']['content'] : '') !!}
                            {{--                            <p class="mb-35">Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum. There are many variations of passages of Lorem Ipsum available, but the majority have alteration in some injected or words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrang hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. </p>--}}
                            {{--                            <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type simen book. It has survived not only five centuries, but also the leap into electronic typesetting. Lorem Ipsum is simply dummy text of the printing and typesetting industry. orem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into unchanged.</p>--}}
                        </div>
                    </div>
                    <div class="row pt-30 pb-20">
                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="tag_cloud">
                                <span>Tags: </span>
                                @forelse($data['post']['tags'] as $tag)
                                    <a href="{{ route('tag.show',$tag->slug) }}"
                                       class="tag-cloud-link">{{ $tag->name }}</a>
                                @empty
                                @endforelse
{{--                                <a href="#" class="tag-cloud-link">Graphics,</a>--}}
{{--                                <a href="#" class="tag-cloud-link">Design,</a>--}}
{{--                                <a href="#" class="tag-cloud-link">Business</a>--}}
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="blog-social text-md-end ">

                            @php
                                $site_url=  Request::url();
                            @endphp
                                <a href="https://twitter.com/share?url=<?=$site_url?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="http://www.facebook.com/sharer.php?u=<?=$site_url?>" target="_blank"><i class="fab fa-facebook"></i></a>
                                <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" target="_blank"><i class="fab fa-pinterest-p"></i></a>
{{--                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="row pr-15 pl-15">
                        <div class="blog-author bg-grey">
                            <div class="blog-author-img f-left">
                                <a href="blog-details.html"><img src="{{asset('public/assets/frontend/img/blog/blog-img-author.jpg')}}" alt="blog-img"></a>
                            </div>
                            <div class="blog-author-text fixed">
                                <h4>Christive eve</h4>
                                <p>It has survived not only five centuries, but also the leap into electronic typesetting unchanged. It was popularised in the sheets containing lorem ipsum is simply free text.</p>
                            </div>
                        </div>
                    </div>

           {{--         <div class="row pr-15 pl-15">
                        <div class="blog-comment-box">
                            <div class="comment-title">
                                <h3 class="comment-box-title"><a href="blog-details.html">2 Comments</a></h3>
                            </div>
                            <div class="blog-single-comment d-flex">
                                <div class="blog-comment-img">
                                    <a href="#"><img src="assets/img/blog/blog-img-author2.png" alt="blog-img"></a>
                                </div>
                                <div class="blog-comment-text">
                                    <h4>Kevin Martin</h4>
                                    <p>A step-by-step tutorial on adding authentication and authorization to your
                                        Next.js apps, with Auth0. We’ll be using a Next.js SDK to connect our
                                        application. </p>
                                </div>
                                <div class="reply-btn">
                                    <a href="#" class="comment-btn">reply</a>
                                </div>
                            </div>
                            <div class="blog-single-comment no-pt d-flex">
                                <div class="blog-comment-img">
                                    <a href="#"><img src="assets/img/blog/blog-img-author3.png" alt="blog-img"></a>
                                </div>
                                <div class="blog-comment-text">
                                    <h4>Jessica Brown</h4>
                                    <p>Everything to keep in mind when designing and building a mega-dropdown, common
                                        pitfalls, hover entry/exit delays, trajectory triangle technique. </p>
                                </div>
                                <div class="reply-btn">
                                    <a href="#" class="comment-btn">reply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-comment-form">
                        <div class="comment-title2">
                            <h3 class="comment-box-title"><a href="#">Leave a Comment</a></h3>
                        </div>
                        <form action="mail.php" id="contact-form" method="POST">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 mb-20">
                                    <input name="name" type="text" placeholder="Your Name">
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 mb-20">
                                    <input name="email" type="text" placeholder="Your Email">
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 mb-20">
                                    <textarea name="message" placeholder="Write Massage"></textarea>
                                </div>
                                <div class="col-xxl-12 col-xl-12 mb-20">
                                    <button type="submit" class="theme-btn border-btn">Submit comment</button>
                                </div>
                            </div>
                        </form>
                        <p class="ajax-response"></p>
                    </div>--}}

                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-md-40 mt-xs-40">
                    <div class="sidebar-wrap">
                        <div class="sidebar-search-from mb-30">
                            <form action="#">
                                <input type="text" placeholder="Search here">
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </form>
                        </div>

                        <div class="widget_-latest-posts mb-30">
                            <h4 class="bs-widget-title mb-25"> Latest Posts </h4>
                            <div class="sidebar__widget-content">
                                <div class="rc-post d-flex mb-15">
                                    <div class="rc-thumb">
                                        <a href="#"><img src="assets/img/blog/sidebar-post-img1.jpg" alt="blog-img"></a>
                                    </div>
                                    <div class="rc-text">
                                        <div class="kblog-meta">
                                            <a href="blog-details.html"><i class="fal fa-user-circle"></i> by Admin</a>
                                        </div>
                                        <h5>
                                            <a href="#">experiences that connect us</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="rc-post d-flex mb-15">
                                    <div class="rc-thumb">
                                        <a href="#"><img src="assets/img/blog/sidebar-post-img2.jpg" alt="blog-img"></a>
                                    </div>
                                    <div class="rc-text">
                                        <div class="kblog-meta">
                                            <a href="blog-details.html"><i class="fal fa-user-circle"></i> by Admin</a>
                                        </div>
                                        <h5>
                                            <a href="#">From banking and insurance to</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="rc-post d-flex">
                                    <div class="rc-thumb">
                                        <a href="#"><img src="assets/img/blog/sidebar-post-img3.jpg" alt="blog-img"></a>
                                    </div>
                                    <div class="rc-text">
                                        <div class="kblog-meta">
                                            <a href="blog-details.html"><i class="fal fa-user-circle"></i> by Admin</a>
                                        </div>
                                        <h5>
                                            <a href="#">We work with you to business</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget_categories grey-bg mb-30">
                            <h4 class="bs-widget-title pl-15">Categories</h4>
                            <ul>
                                @forelse($data['categories'] as $category)
                                    <li><a href="{{ route('category.show',$category->slug) }}">{{ $category->name }}</a>
                                    </li>
                                @empty
                                @endforelse
                                {{--<li><a href="#">Web Developement</a></li>
                                <li><a href="#">Graphic Design</a></li>
                                <li><a href="#">SEO &amp; Content Writting</a></li>
                                <li><a href="#">Digital Marketing</a></li>
                                <li><a href="#">App Development</a></li>--}}
                            </ul>
                        </div>
                        <div class="widget_tag_cloud">
                            <h4 class="bs-widget-title mb-25"> Tags </h4>
                            <div class="tagcloud">
                                @forelse($data['post']['tags'] as $tag)
                                    <a href="{{ route('tag.show',$tag->slug) }}"
                                       class="tag-cloud-link">{{ $tag->name }}</a>
                                @empty
                                @endforelse
                                {{--                            <a href="#" class="tag-cloud-link">Graphics</a>
                                                                <a href="#" class="tag-cloud-link">Design</a>
                                                                <a href="#" class="tag-cloud-link">Business</a>
                                                                <a href="#" class="tag-cloud-link">development</a>
                                                                <a href="#" class="tag-cloud-link">Technology</a>
                                                                <a href="#" class="tag-cloud-link">Content</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog details area end  -->



    <!-- Page Header-->
    {{-- <header class="masthead"
             style="background-image: url('{{ (isset($data['post']->thumbnail) ? asset($data['post']->thumbnail) : asset('/public/storage/placeholder.jpg')) }}')">
         <div class="container position-relative px-4 px-lg-5">
             <div class="row gx-4 gx-lg-5 justify-content-center">
                 <div class="col-md-12 col-lg-12 col-xl-12">
                     <div class="post-heading">
                         <p>
                             <a class="bg-danger p-2 text-white text-decoration-none" href="{{ (isset($data['post']->category->name) ? route('category.show',$data['post']->category->slug) : '') }}">{{ (isset($data['post']->category->name) ? $data['post']->category->name : '') }}</a>
                         </p>
                         <h1 class="mb-2">{{(isset($data['post']->title) ? $data['post']->title : '')}}</h1>
                         --}}{{--<h2 class="subheading">Problems look mighty small from 150 miles up</h2>--}}{{--
                         <p class="meta">
                             Posted by <a class="text-decoration-none" href="#!">{{ (isset($data['post']->admin->name) ? $data['post']->admin->name : '') }}</a>
                             on {{(isset($data['post']->created_at) ? $data['post']->created_at->format('d-m-Y') : '')}}
                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </header>
     <div class="container mb-4">
         <article class="entry row">
             <div class="col-12 individual-detail">
                 <div class="mb-4">
                     @isset($data['post']->tags)
                         @foreach($data['post']->tags as $tag)
                             <a class="badge bg-secondary text-decoration-none link-light" href="{{ route('tag.show',$tag->slug) }}">{{ $tag->name }}</a>
                         @endforeach
                     @endisset
                 </div>
                 {!! (isset($data['post']->content) ? $data['post']->content : '') !!}
             </div>
         </article>
     </div>--}}
@endsection
@section('script')

    @include('flashy::message')

    <script></script>

@endsection
