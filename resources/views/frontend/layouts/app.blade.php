<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="{{ route('home') }}" name="base-url"/>
    <meta content="{{ csrf_token() }}" name="csrf-token"/>

    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta content="@yield('keywords')" name="keywords">
    <meta content="@yield('description')" name="description"/>
    <link href="@yield('canonical', route('home'))" rel="canonical"/>
    <meta content="{{ config('app.name') }}" name="author"/>
    <meta content="Document" name="Resource-type"/>
    <meta content="@yield('robots', 'index,follow')" name="robots">

    <!-- Open Graph / Facebook -->
    <meta content="{{ config('app.name') }}" property="og:site_name">
    <meta content="@yield('type','website')" property="og:type">
    <meta content="@yield('canonical', route('home'))" property="og:url"/>
    <meta content="@yield('title') - {{ config('app.name') }}" name="title" property="og:title">
    <meta content="@yield('description')" name="description" property="og:description">
    <meta content="@yield('image',asset('public/assets/frontend/images/logo.png'))" name="image" property="og:image">
    <!-- Twitter -->
    <meta content="summary_large_image" name="twitter:card"/>
    <meta content="@yield('canonical', route('home'))" property="twitter:url">
    <meta content="@yield('type') - {{ config('app.name') }}" name="twitter:title"/>
    <meta content="@yield('description')" name="twitter:description"/>
    <meta content="@yield('image',asset('public/assets/frontend/images/logo.png'))" name="twitter:image"/>

    <script type="application/ld+json">
        {
        "@context":"https:\/\/schema.org",
        "@type":"@yield('type')",
        "name":"@yield('title')",
        "description":"@yield('description','website description')",
        "url":"@yield('canonical')"}
    </script>

    <link href="{{asset('public/assets/backend/favicon.ico')}}" rel="icon" type="image/x-icon"/>
    <!-- Font Awesome icons (free version)-->
    <script crossorigin="anonymous" src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('public/assets/frontend/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/assets/frontend/css/style.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/assets/frontend/css/styles.css')}}" rel="stylesheet"/>

    @yield('style')
</head>
<body>

<!-- Navigation-->
@include('frontend.includes.navigation')
@yield('content')
@include('frontend.includes.footer')


<script src="{{asset('public/assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/popper.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/frontend/js/jquery-3.5.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/frontend/js/image-uploader.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/backend/js/jquery-ui.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}" type="application/javascript"></script>
<script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}" type="application/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<!-- Core theme JS-->
<script src="{{asset('public/assets/frontend/js/scripts.js')}}" type="text/javascript"></script>
@stack('js')
@yield('script')

</body>
</html>
