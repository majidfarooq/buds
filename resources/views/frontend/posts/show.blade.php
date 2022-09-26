@extends('frontend.layouts.app')

@section('style')
@endsection

@section('type'){{ 'Article' }}@endsection
@section('title'){{ isset($data['post']['meta_title']) ? $data['post']['meta_title'] : $data['post']['title'] }}@endsection
@section('description'){{ isset($data['post']['meta_description']) ? $data['post']['meta_description'] : strip_tags(\Illuminate\Support\Str::limit($post->content, 155)) }}@endsection
@section('keywords'){{ isset($data['post']['meta_keyword']) ? $data['post']['meta_keyword'] : '' }}@endsection
@section('canonical'){{ Request::url() }}@endsection

@section('content')

    <!-- Page Header-->

    <header class="masthead"
            style="background-image: url('{{ (isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg')) }}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="post-heading">
                        <p>
                            <a class="bg-danger p-2 text-white text-decoration-none" href="{{ isset($data['category']['slug']) ? route('category.show',$data['category']['slug']) : '' }}">{{ (isset($data['post']['category']['name']) ? $data['post']['category']['name'] : '') }}</a>
                        </p>
                        <h1 class="mb-2">{{(isset($data['post']['title']) ? $data['post']['title'] : '')}}</h1>
                        {{--<h2 class="subheading">Problems look mighty small from 150 miles up</h2>--}}
                        <p class="meta">
                            Posted by <a class="text-decoration-none" href="#!">{{ (isset($data['post']['admin']['name']) ? $data['post']['admin']['name'] : '') }}</a>
                            on {{(isset($data['post']['created_at']) ? $data['post']['created_at']->format('d-m-Y') : '')}}
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
                    @isset($data['post']['tags'])
                        @foreach($data['post']['tags'] as $tag)
                            <a class="badge bg-secondary text-decoration-none link-light" href="{{ route('tag.show',$tag->slug) }}">{{ $tag->name }}</a>
                        @endforeach
                    @endisset
                </div>
                {!! (isset($data['post']['content']) ? $data['post']['content'] : '') !!}
            </div>
        </article>
    </div>

@endsection
@section('script')

    @include('flashy::message')

    <script></script>

@endsection
