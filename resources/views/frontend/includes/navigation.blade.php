<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="main-navigation navbar-nav ms-auto py-4 py-lg-0">
                @isset($header)
                    @foreach($header->MenuItem as $item)
                        @if($item->page_type == 'cms')
                            @php $route = route('page.show', $item->page->slug); @endphp
                        @elseif($item->page_type == 'static')
                            @php $route = \Illuminate\Support\Facades\URL::to("/").$item->url; @endphp
                        @elseif($item->page_type == 'external')
                            @php $route =$item['url']; @endphp
                        @endif
                        @php $id = 'li_id_'.rand(); @endphp

                        <li class="nav-item @if($item->submenu->count() > 0){{'dropdown'}}@endif">
                            <a id="{{ $id }}"
                               class="nav-link @if($item->submenu->count() > 0){{'dropdown-toggle'}}@endif px-lg-3 py-3 py-lg-4"
                               href="{{ $route }}"
                               target="@if($item->page_type == 'external'){{'_blank'}}@else{{'_self'}}@endif">
                                <span class="menu-text">{{$item->title}}</span>
                            </a>
                            @if($item->submenu->count() > 0)
                                <ul class="dropdown-menu" aria-labelledby="{{ $id }}">
                                    @foreach($item->submenu as $submen)
                                        @if($submen->page_type == 'cms')
                                            @php $route = route('page.show', $submen->page->slug); @endphp
                                        @elseif($submen->page_type == 'static')
                                            @php $route = \Illuminate\Support\Facades\URL::to("/").$submen->url; @endphp
                                        @elseif($submen->page_type == 'external')
                                            @php $route =$submen['url']; @endphp
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ $route }}">{{$submen->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>

                    @endforeach
                @endisset
                @auth
                    <li class="nav-item">
                        <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('user.dashboard')}}" target="_self">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('login')}}" target="_self">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('register')}}" target="_self">Sign Up</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>