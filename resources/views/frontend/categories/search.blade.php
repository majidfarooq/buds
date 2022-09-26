@extends('frontend.layouts.app')

@section('style')
    <style></style>
@endsection
@section('content')
    <div class="container-fluid page-title">
        <div class="row">
            <div class="container-xl">
                <div class="col-12 p-0 text-center">
                    <h1 class="mt-5 mb-5">EXPERIENCES</h1>
                    <form action="{{route('categories.search')}}" method="post">
                        <div class="gray-area mb-5 col-12">
                            <div class="row">
                                @csrf
                                @method('post')
                                <div class="form-group pl-2 pr-2 mt-3 mb-3 col-md-3 col-sm-12">
                                    <div class="bg-white">
                                        <label class="" for="category">Experience Type</label>
                                        <select name="category" id="category" class="form-control">
                                            @isset($cat)
                                                @foreach($cat as $c)
                                                    <option
                                                        value="{{$c->id}}" @isset($data['category']) {{ $data['category'] == $c->id ? 'selected' : '' }}@endisset>{{$c->name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mt-3 mb-3 col-md-3 col-sm-12">
                                    <div class="bg-white">
                                        <label class="city" for="city">Location</label>
                                        <select name="city" id="city" class="form-control">
                                            @isset($cities)
                                                @foreach($cities as $city)
                                                    @isset($city['city'])
                                                        <option
                                                            value="{{$city['city']}}" @isset($data['city']) {{ $data['city'] == $city['city'] ? 'selected' : '' }}@endisset>{{$city['city']}}</option>
                                                    @endisset
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mt-3 mb-3 col-md-3 col-sm-12">
                                    <div class="bg-white">
                                        <label class="" for="date">Dates</label>
                                        <input id="date" placeholder="Add Dates"
                                               value="{{ ($data['date'])?$data['date']:  Carbon\Carbon::now()->format('Y-m-d') }}"
                                               class="form-control" name="date"
                                               type="date">
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mt-3 mb-3 col-md-3 col-sm-12 form-search">
                                    <button class="btn btn-primary w-100" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-5 pb-5 restaurant-section">
        <div class="row">
            <div class="container-xl">
                @if (isset($experiences))
                    <div class="row">
                        @foreach($experiences as $experience)
                            <div class="col-lg-4 col-md-12">
                                <div class="fusion-text mb-3 single-col home-technology-solutions">
                                    <div class="categor-listing-img">
                                        <a href="{{route('experience.show',$experience->slug)}}">
                                            <img class="double-img" src="{{$experience->futureimage}}">
                                        </a>
                                    </div>
                                    <div class="image-text position-a w-100">
                                        <div class="row">
                                            <div class="col">
                                                <p>{{isset($experience->location) ? $experience->location:''}}</p>
                                                <h6 class="mb-3 mt-3">{{$experience->title}}</h6>
                                                <div class="link-thumbnail">
                                                    <a href="#">
                                                        <img src="{{asset('public/assets/frontend/images/star.png')}}">
                                                    </a>
                                                    <a href="#">4.95 </a>
                                                    <a href="#">Experienced by</a>
                                                    <a href="#">987</a>
                                                </div>
                                            </div>
                                            <div class="col text-right">
                                                @isset($experience->slots)
                                                    @foreach($experience->slots as $slot)
                                                        <h6 class="mb-1 mt-1">{{$slot->from}} - {{$slot->to}}</h6>
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('script')

    @include('flashy::message')

    <script></script>

@endsection
