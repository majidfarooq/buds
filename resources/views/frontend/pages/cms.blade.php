@extends('frontend.layouts.app')

@section('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/frontend/css/fullpage.css') }}"/>
  <style rel="stylesheet">
      .banner_text {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 100%;
          text-align: center;
      }
      {{(isset($page['page_css']) ? $page['page_css'] : '')}}
  </style>
@endsection

@section('title'){{(isset($page['meta_title']) ? $page['meta_title'] : '')}}@endsection
@section('description'){{(isset($page['meta_description']) ? $page['meta_description'] : '')}}@endsection
@section('keywords'){{(isset($page['meta_keyword']) ? $page['meta_keyword'] : '')}}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')
  <div id="@if ($page->page_type == 'fullpage'){{'fullpage'}}@endif">
    <!-- Page Header-->
    <header class="masthead @if ($page->page_type == 'fullpage'){{'section'}}@endif" style="background-image: url('{{ isset($page['banner']) ? asset($page['banner']) : '' }}')">
      <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
          <div class="col-md-10 col-lg-8 col-xl-7">
            <div
              class="site-heading text-uppercase">{!! isset($page['banner_content']) ? $page['banner_content'] : '' !!}</div>
          </div>
        </div>
      </div>
    </header>

    @if (isset($page))
      @foreach ($page->pageSections as $pg)
        <div class="@if ($page->page_type == 'fullpage'){{'section'}}@endif {{ ($pg->container_type) ? $pg->container_type : '' }} {{ ($pg->e_class) ? $pg->e_class : '' }} mb-5" id="{{ ($pg->e_id) ? $pg->e_id : '' }}">
          <div class='row mx-0 '>
            @foreach ($pg->section->PageSubSections as $ss)
              <div class='col-lg-{{$ss->row_width}} parent-col'>
                @isset($pg->subsection)
                  @foreach ($pg->subsection as $subsection)
                    @if ($subsection->sub_section_id == $ss->id)
                      <div class="row mb-4">
                        @foreach ($subsection->section->PageSubSections as $pss)
                          <div class='col-lg-{{$pss->row_width}}'>
                            @isset($subsection->PageElements)
                              <?php
                              $pageContent = '';
                              foreach ($subsection->PageElements as $pSubE) {
                              if ($pss->id == $pSubE->sub_section_id && $pSubE['element']['type'] != 'daughter') {
                              ?>
                              @include('frontend.pages.element',['pageElement'=>$pSubE])
                              <?php }} ?>
                              @isset($pContent)
                                {!! isset($pContent) ? $pContent : '' !!}
                              @endisset
                            @endisset
                          </div>
                        @endforeach
                      </div>
                    @endif
                  @endforeach
                @endisset



                @isset($pg->PageElements)
                  <?php
                  $pageContent = '';
                  foreach ($pg->PageElements as $pgE) {
                  if ($pgE->sub_section_id == $ss->id && $pgE['element']['type'] != 'daughter') { ?>
                  @include('frontend.pages.element',['pageElement'=>$pgE])
                  <?php }} ?>
                  @isset($pageContent)
                    {!! isset($pageContent) ? $pageContent : '' !!}
                  @endisset
                @endisset
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    @endisset

    @if (isset($data['posts']) && count($data['posts']) > 0)
      <div class="@if ($page->page_type == 'fullpage'){{'section'}}@endif container mb-4">
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
  </div>
@endsection

@section('script')
    @include('flashy::message')
    <script type="text/javascript" src="{{ asset('public/assets/frontend/js/fullpage.js') }}"></script>
    <script type="text/javascript">
        var myFullpage = new fullpage('#fullpage', {
            // sectionsColor: ['#d72e2d', '#d72e2d', '#d72e2d', '#d72e2d', '#d72e2d'],
            // anchors: ['homesection', 'the-GKE', 'services', 'product-press-release', 'ways-to-work', 'contact'],
            navigation: true,
            navigationPosition: 'right',
            showActiveTooltip: true,
            menu: '#menu',
            licenseKey: 'OPEN-SOURCE-GPLV3-LICENSE',
            // licenseKey: 'YWx2YXJvdHJpZ28uY29tXzlNZGNHRnlZV3hzWVhnPTFyRQ==',
            responsiveWidth: 991,
            afterResponsive: function (isResponsive) {

            }
        });
    </script>
    <script type="text/javascript">
        {{(isset($page['page_script']) ? $page['page_script'] : '')}}
        $('.carousel').each(function () {
            $(this).find('.carousel-item:eq(0)').addClass('active');
        });
    </script>
    <script type="text/javascript">
        $(function () {
            let icons = {
                header: "fas fa-arrow-right",
                activeHeader: "fas fa-arrow-down"
            };
            $("#accordion").accordion({
                collapsible: true,
                icons: icons
            });
            $("#toggle").button().on("click", function () {
                if ($("#accordion").accordion("option", "icons")) {
                    $("#accordion").accordion("option", "icons", null);
                } else {
                    $("#accordion").accordion("option", "icons", icons);
                }
            });
        })
    </script>
@endsection
