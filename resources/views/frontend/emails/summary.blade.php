@extends('frontend.layouts.app')

@section('style')
    <style></style>
@endsection
@section('content')
    <div class="container-fluid page-title">
        <div class="row">
            <div class="container">
                <div class="col-12 p-5 text-center">
                    <h1>INVITATION DETAILS</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="col-12 p-0 text-center messages"></div>
            </div>
        </div>
    </div>

    <div class="container-fluid content-section pb-5 pt-5">
        <div class="row">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-8 col-md-12 friends-invited">
                        <div class="card p-4 pb-0 booking-section">
                            <div class="col-lg-12 col-md-12 mb-3 p-0">
                                <h5 class="mt-3">INVITATION DETAILS</h5>
                            </div>
                            <!--Accordion wrapper-->
                            @isset($data['trip']->bookings)
                                @php $cnter = 1; $totalTripAmount=0;@endphp
                                @foreach($data['trip']->bookings as $booking)
                                    <div class="accordion md-accordion"
                                         id="accordionEx_{{(isset($booking->id) ? $booking->id : '')}}"
                                         role="tablist"
                                         aria-multiselectable="{{ $loop->first ? 'true' : 'false' }}"
                                         data-expId="{{(isset($booking->experience->id) ? $booking->experience->id : '')}}"
                                         data-slotId="{{isset($booking->slot->id) ? $booking->slot->id : ''}}"
                                         data-date="{{isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : ''}}"
                                         data-from="{{isset($booking->from) ? $booking->from : ''}}"
                                         data-to="{{isset($booking->to) ? $booking->to : ''}}"
                                         data-amount="{{isset($booking->total_amount) ? $booking->total_amount : ''}}"
                                         data-guest="{{isset($booking->numberOfPeople) ? $booking->numberOfPeople : ''}}">

                                        <!-- Accordion card -->
                                        <div class="card border-0 mb-4">
                                            <!-- Card header -->
                                            <div class="card-header border-0 bg-white box-shadow p-0" role="tab"
                                                 id="headingOne1">
                                                <a data-toggle="collapse"
                                                   data-parent="#accordionEx_{{(isset($booking->id) ? $booking->id : '')}}"
                                                   href="#collapseP_{{(isset($booking->id) ? $booking->id : '')}}"
                                                   aria-expanded="true"
                                                   aria-controls="collapseP_{{(isset($booking->id) ? $booking->id : '')}}">
                                                    <div class="row">
                                                        <div class="experience-img col-lg-2 col-md-3 col-sm-3 p-0">
                                                            <img src="{{asset('public/assets/frontend/images/experience.png')}}">
                                                        </div>
                                                        <div class="experience-content col-lg-9 col-md-7 col-sm-6 p-0">
                                                            <p>{{(isset($booking->experience->category->name) ? $booking->experience->category->name : '')}}</p>
                                                            <h6>{{(isset($booking->experience->title) ? $booking->experience->title : '')}}</h6>
                                                        </div>
                                                        <div class="experience-content col-lg-1 col-md-2 col-sm-3 p-0 text-center">
                                                            <h5 class="float-right mb-0">
                                                                <i class="fas fa-angle-down rotate-icon"></i>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- Card body -->
                                            <div id="collapseP_{{(isset($booking->id) ? $booking->id : '')}}"
                                                 class="collapse {{ $loop->first ? 'show' : '' }}"
                                                 role="tabpanel"
                                                 aria-labelledby="headingOne1"
                                                 data-parent="#accordionEx_{{(isset($booking->id) ? $booking->id : '')}}">
                                                <div class="card-body p-0">
                                                    <div class="row">
                                                        <div class="experience-img col-lg-2 col-md-12 p-0"></div>
                                                        <div class="col-lg-10 col-md-8 col-sm-12 pt-2 px-0">
                                                            <div class="booking-list mb-4">
                                                                <p>Date & Time</p>
                                                                <h6>{{isset($booking->date) ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : ''}}
                                                                    - {{isset($booking->from) ? \Carbon\Carbon::parse($booking->from)->format('g:i A') : ''}}</h6>
                                                            </div>
                                                            <div class="booking-list mb-4">
                                                                <p>Price</p>
                                                                @php $totalPrice=0;  @endphp
                                                                @php
                                                                    $price = $booking->experience->base_price;
                                                                    $totalPrice=$totalPrice+$price;
                                                                @endphp
                                                                <h6>
                                                                    ${{$totalPrice}}
                                                                    @php $totalTripAmount = $totalTripAmount + $booking->total_amount @endphp
                                                                </h6>
                                                            </div>
                                                            <div class="booking-list mb-4">
                                                                <p>No. of Guest</p>
                                                                <h6>{{isset($booking->numberOfPeople) ? $booking->numberOfPeople : ''}}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $cnter++; @endphp
                                @endforeach
                            @endisset
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 friends-invited">
                        <div class="col-lg-12 col-md-12 mb-3">
                            @php $auth = Auth::user(); @endphp
                            @if(isset($auth) && $auth->role_id == 1)
                                <form action="{{route('invite.status')}}" method="post">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" name="role_id" value="{{$auth->role_id}}">
                                    <input type="hidden" name="user_email" value="{{$auth->email}}">
                                    <input type="hidden" name="order_id" value="{{$data['trip']->id}}">
                                    <button class="mb-4 btn btn-primary hvr-float-shadow w-100" type="submit"
                                            name="status" value="accept">ACCEPT
                                    </button>
                                    <button class="mb-4 btn btn-danger hvr-float-shadow w-100" type="submit"
                                            name="status" value="reject">REJECT
                                    </button>
                                </form>
                            @else
                                <p>Please Register first using the same e-mail address in order to
                                    collaborate for this trip.</p>
                                <a class="mb-4 btn btn-primary hvr-float-shadow w-100" data-toggle="modal"
                                   data-target=".bd-example-modal-lg">SIGN UP</a>
                            @endif
                        </div>
                    </div>

                    @if(isset($auth) && $auth->role_id == 1)
                        <div class="col-lg-12 col-md-12 mb-3 mt-5">
                            <div class="row">
                                <div class="ml-auto col-lg-5 col-md-12 mb-3">
                                    <div class="form-group">
                                        <div class="btn-group">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn btn-secondary dropdown-toggle"
                                                    type="button" id="openMessages"
                                                    data-trip="{{(isset($att['tripId'])?$att['tripId']:'0')}}">
                                                <img class="mr-2"
                                                     src="{{asset('public/assets/frontend/images/message.png')}}">
                                                Messages
                                                <span id="msgCount"
                                                      class="badge badge-pill badge-warning ml-2 mr-2">0</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset


                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3 message-position" style="display: none" id="messageBox">

                                <div class="card form-card summary-pos ml-auto col-lg-4 col-md-12 col-sm-12 p-0">
                                    <div class="card-body p-0">
                                        <div class="chat_box">
                                            <div class="head">
                                                @php $user = \Illuminate\Support\Facades\Auth::user() @endphp
                                                <div class="user">
                                                    <div class="avatar">
                                                        <img src="https://picsum.photos/g/40/40">
                                                    </div>
                                                    <div class="name">{{(isset($user->first_name) ? $user->first_name.' ' : '')}} {{(isset($user->last_name) ? $user->last_name : '')}}</div>
                                                </div>
                                            </div>
                                            <div class="body">
                                            </div>
                                            <div class="foot">
                                                <form id="send_message" class="w-100 d-flex">
                                                    <input id="myMessage" type="text" name="message"
                                                           class="msg form-control" placeholder="Type a message...">
                                                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tripId" name="tripId" value="{{(isset($data['trip']->id)?$data['trip']->id:'0')}}">
    <input type="hidden" id="tripType" name="tripType" value="{{(isset($data['trip']->type)?$data['trip']->type:'')}}">

@endsection
@section('script')

    @include('flashy::message')

    <script></script>
    <script>

        $(document).ready(function () {
            getUnreadMsg();
        });

        function getUnreadMsg() {
            var tripId = $("#tripId").val();
            var tripType = $("#tripType").val();
            $.ajax({
                type: "POST",
                url: "{{ route('user.get.messageCount') }}",
                data: {
                    tripId: tripId,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    if (data.success) {
                        $('#msgCount').html(data.content);
                    }
                    console.log('success', data);
                }
            })
        }

        function getMessages() {
            var tripId = $("#tripId").val();
            var tripType = $("#tripType").val();
            if (tripType === '' || tripType === 'trip' || tripId === 0) {
                alert('Please try to save before opening the chat');
                $('#messageBox').hide();
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.get.messages') }}",
                    data: {
                        tripId: tripId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        if (data.success) {
                            $('.chat_box .body').html(data.content);
                            getUnreadMsg();
                        }
                        console.log('success', data);
                    }
                })
            }
        }

        $('#openMessages').click(function () {
            var id = $(this).data('trip');
            if ($("#messageBox").css('display').toLowerCase() === 'none') {
                $('#messageBox').show();

                $(".chat_box .body").animate({
                    scrollTop: $(
                        '.chat_box .body').get(0).scrollHeight
                }, 2000);

                getMessages();
            } else {
                $('#messageBox').hide();
            }
        });

        $("#send_message").validate({
            rules: {
                "message": {
                    required: true,
                },
            },
            messages: {
                "message": {
                    required: "Please, Type your message",
                },
            },
            submitHandler: function (form) {
                event.preventDefault();
                sendMessage();
            }
        });

        function sendMessage() {
            var message = $("#myMessage").val();
            var tripId = $("#tripId").val();
            var tripType = $("#tripType").val();
            $.ajax({
                type: "POST",
                url: "{{ route('user.send.message') }}",
                data: {
                    tripId: tripId,
                    tripType: tripType,
                    message: message,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    if (data.success) {
                        $('#myMessage').attr('value', '');
                        getMessages();
                    } else {
                        $('.messages').html('<div class="alert alert-danger mt-4 mb-4 p-2">' +
                            '<button type="button" class="close" data-dismiss="alert">×</button>' +
                            '<strong>something wrong</strong>' +
                            '</div>');
                    }
                }
            })
        }

    </script>
@endsection
