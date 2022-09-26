<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="#!">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                </ul>
                <ul class="list-inline text-center">
                    @if(isset($footer))
                    @foreach($footer as $menu)
                        @isset($menu->MenuItem)
                            @foreach($menu->MenuItem as $item)
                                @if($item->page_type == 'cms')
                                    <li class="list-inline-item cms">
                                        <a href="{{route('pages.show',$item->page->slug)}}">{{$item->title}}</a>
                                    </li>
                                @elseif($item->page_type == 'static')
                                    <li class="list-inline-item static">
                                        <a href="{{ \Illuminate\Support\Facades\URL::to("/").$item->url}}">{{$item->title}}</a>
                                    </li>
                                @elseif($item->page_type == 'external')
                                    <li class="list-inline-item external">
                                        <a href="{{$item['url']}}" target="_blank">{{$item->title}}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endisset
                    @endforeach
                @endif
                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; Your <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a> 2021</div>
            </div>
        </div>
    </div>
</footer>
