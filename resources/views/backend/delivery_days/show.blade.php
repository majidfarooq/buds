@extends('backend.layouts.app')
@section('style')
    <style type="text/css">
        td.action {display: flex ; gap: 10px;}

        [data-title]:hover:after {opacity: 1 ; transition: all 0.1s ease 0.5s ; visibility: visible;}
        [data-title]:after {
            content: attr(data-title) ; background-color: #f8f9fc ; color: #4e73df ; font-size: 15px ; position: absolute ; padding: 1px 5px 2px 5px ; top: -35px ; left: 0 ; white-space: nowrap ; box-shadow: 1px 1px 3px #4e73df ; opacity: 0 ; border: 1px solid #4e73df ; z-index: 99999 ; visibility: hidden;
        }
        [data-title] {position: relative;}
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
            @endif
            <!--end card-body-->
            </div>
        </div>
        <!--end col-->

    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
{{--    @dd($error_logs[10])--}}
        <!-- DataTales Example -->
        <div class="card shadow shadow mb-4 user-list p-4 dilevey_days">
            <div class="d-flex justify-content-between align-items-center pt-3">
                <h5>Deliveries</h5>
                <div class="d-flex dilevey_days">
                    <h4 class="title">Today’s Date:</h4>
                    <h3 class="date mx-4">{{ date('j M Y') }}
                    </h3>
                </div>
            </div>
            <div class="text-center date-full col-12 mb-4">
                <div class="row w-100">
                <div class="offset-lg-3 col-lg-6 col-md-12 d-flex justify-content-center align-items-center">
                    @if ($previousDay == null)
                    @else
                    <a href="{{ route('admin.delivery_days.show', $previousDay->id) }}"> <i class="fa fa-angle-left"></i></a>
                    @endif
                <h3 class="date mx-4">{{ \Carbon\Carbon::parse($delivey_days->delivery_date)->format('j M Y') }}
                </h3>
                   @if ($nextDay == null)
                     @else
                     <a href="{{ route('admin.delivery_days.show', $nextDay->id) }}"><i class="fa fa-angle-right"></i></a>
                   @endif

                </div>
                <div class="col-lg-3 col-md-12 date-full-btn">
                    <a class="btn btn-primary btn-user" href="{{ route('admin.delivery_days.create') }}">
                        <h4 class="mb-0">Create Additional Delivery</h4></a>
                </div>
                </div>
            </div>
            <div class="border-1 delivery-main-area delivery-days-border delivery-search-show p-2">
                <div class="card-body p-0">
                    <div class="table-responsive user-package delivery-section">
                        <div class="d-flex">
                            <h4 class="title mb-0">Delivery List</h4>
                            <h3 class="date mx-4 mb-0">{{ \Carbon\Carbon::parse($delivey_days->delivery_date)->format('j M Y') }}
                            </h3>
                            <h4 class="days mb-0">{{ $delivey_days->deliver_to }}</h4>

                        </div>
                        <table class="table table-bordered table-striped" id="delivery_days">
                            <thead>
                            <th><div class="form-group check">
                                    <input type="checkbox" class="selectall Checkbox-visible" name="friday" id="selectall" value="friday">
                                </div></th>
                            <th>
                            </th>
                            <th>Name</th>
                            <th>Package</th>
                            <th>Contact</th>
                            <th>Delivery Address</th>
                            <th>Confirmation</th>
                            <th>Frequency</th>
                            <th>Notes</th>
                            <th>Route</th>
                            </thead>
                            <tbody id="ajaxSearchResults">
                            @if ($delivey_days->deliveries)
                                @foreach ($delivey_days->deliveries as $delivey)
                                    <tr role="row" class="even">
                                        @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($delivey->id)  @endphp
                                        <td>
                                            <div class="form-group check">
                                                <input type="checkbox" class="Checkbox-visible" name="friday" id="colors[]" value="friday">
                                            </div>
                                        </td>
                                        <td>
                                            @if ($delivey->user_package->remaining_deliveries < 0)
                                                <img src="{{asset('/public/assets/backend/img/dollar-cancel.png')}}">
                                            @elseif ($delivey->user_package->remaining_deliveries  > 0)
                                                <img src="{{asset('/public/assets/backend/img/dollar-succes.png')}}">
                                            @endif
                                        </td>
                                        <td><a target="_blank" href="{{ route('admin.users.show', $delivey->user_package->user->slug) }}">{{ $delivey->user_package->user->first_name }} {{ $delivey->user_package->user->last_name }}</a> </td>
                                        <td>{{ $delivey->user_package->package->title }}<br>{{ $delivey->user_package->type }}</td>
                                        <td>{{$delivey->user_package->user->business_name}} <br> {{$delivey->user_package->user->recipient_name}}<br> {{$delivey->user_package->user->recipient_phone}}</td>
                                        <td>{{$delivey->user_package->user->delivery_address1}}, {{$delivey->user_package->user->delivery_address2}}

                                        </td>
                                        {{-- 'Pending','Suspended','Canceled','Paid','Failed' --}}
                                        <td>@if($delivey_days->status =='Pending')
                                                @if($delivey->user_package->status == 'suspended')
                                                    Suspended <br><small>{{$delivey->user_package->suspended_until}}</small>
                                                @elseif($delivey->user_package->status == 'in Active')
                                                    {{$delivey->user_package->status}}
                                                @else
                                                    @if ($delivey->status== 'Canceled')
                                                        <div class="cancel" id="cancel_{{$delivey_days->id}}">
                                                            <a onclick="changeStatusCancel(this)" data-cancelId="{{$delivey->id}}">
                                                                <p data-title="Cancelled" class="red"><span  class="" >{{$delivey->status}}</span></p></a>

                                                        </div>
                                                    @elseif ($delivey->status== 'Pending')
                                                        <div class="cancel" id="cancel_{{$delivey_days->id}}">
                                                            <a onclick="changeStatusCancel(this)" data-cancelId="{{$delivey->id}}"><p data-title="Cancelled" class="">Cancel</p></a>
                                                        </div>
                                                    @else
                                                        {{$delivey->status}}
                                                    @endif
                                                @endif
                                            @else
                                                <div class="col-md-12 failed tooltip" >
                                                    @if ($delivey->status== 'Failed')
                                                        {{$delivey->status}}
                                                     <p class="error_logs_paragraph tooltiptext">@if(isset($error_logs[$delivey->id])) {{$error_logs[$delivey->id]}}@endif</p>
                                                    @else
                                                       @if(isset($delivey->status)) {{$delivey->status}} @endif
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $delivey->user_package->type }}</td>
                                        <td>{{ $delivey->user_package->description }}{{ $delivey->user_package->user->notes }}</td>
                                        <td>{{ (isset($delivey->route) ? $delivey->route : '') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                    @if($delivey_days->status == 'Completed')
                    <div class="paid-unpaid-dd d-flex gap-4" id="faileddeliveries">
                        <p class="mb-0 green">Paid Deliveries {{ $delivey_days->Paiddeliveries }}</p>
                        <p class="mb-0">|</p>
                        <p class="mb-0 red" style="cursor: pointer">Un-Paid Deliveries {{ $delivey_days->Faileddeliveries }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div id="allFailedDeliverShow" class="mt-4 px-5 bg-white shadow p-0" style="display: none;cursor: pointer">
                <div class="col-12 text-end p-0">
                    <i class="croos-code" id="croos">&#9587</i>
                </div>
                <div class="col-10 mt-4 mb-3">
                    <h3 class="date">All Un-Paid Deliveries</h3>
                </div>
                <table class="table table-bordered table-striped" id="delivery_days">
                    <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Package</th>
                    <th>Contact</th>
                    <th>Delivery Address</th>
                    <th>Frequency</th>
                    <th>Notes</th>
                    <th>Route</th>
                    </thead>
                    <tbody id="ajaxSearchResults">
                    @foreach ($delivey_days->deliveries as $delivey)
                        @if($delivey->status == 'Failed')
                            <tr role="row" class="even">
                                @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($delivey->id)  @endphp
                                <td>
                                    <img src="{{asset('/public/assets/backend/img/dollar-cancel.png')}}">
                                </td>
                                <td><a target="_blank" href="{{ route('admin.users.show', $delivey->user_package->user->slug) }}">{{ $delivey->user_package->user->first_name }} {{ $delivey->user_package->user->last_name }}</a> </td>
                                <td>{{ $delivey->user_package->package->title }}<br>{{ $delivey->user_package->type }}</td>
                                <td>{{$delivey->user_package->user->business_name}} <br> {{$delivey->user_package->user->recipient_name}}<br> {{$delivey->user_package->user->recipient_phone}}</td>
                                <td>{{$delivey->user_package->user->delivery_address1}}, {{$delivey->user_package->user->delivery_address2}}
                                </td>
                                <td>{{ $delivey->user_package->type }}</td>
                                <td>{{ $delivey->user_package->description }}{{ $delivey->user_package->user->notes }}</td>
                                <td>{{ (isset($delivey->route) ? $delivey->route : '') }}</td>
                            </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="row mt-5 pt-5 confirm-delivery">
                @if($delivey_days->status == 'Pending')
                    <div class="offset-3 col-lg-5 col-md-12 confirm-delivery-chekbox">
                        {!! Form::open(["route" => ["admin.user_packages.cancelThisWeek"],"id"=>"cancelThisWeek","files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
                        <input type="hidden" name="delivery_day_id" value="{{ $delivey_days->id }}" id="delivery_day_id">
                        <div class="form-group checkbox">
                            <input type="checkbox" name="friday" id="canceling_deliveries" value="friday">
                            <label class="d-block" for="canceling_deliveries">I Confirm canceling all Deliveries for this week.</label>
                            <span id="errorToShow"></span>
                        </div>
                        <button class="btn btn-primary btn-user" id="cancelSkip" type="submit">
                            <h4 class="mb-0">Cancel All - Skip This Week</h4></button>
                        {!! Form::close() !!}
                    </div>

                <div class="col-lg-4 col-md-12 confirm-delivery-chekbox">
                    {!! Form::open(['route' => 'admin.user_packages.runBulkTrasections','id' => 'runBulkTransections']) !!}
                    <input type="hidden" name="delivery_day_id" value="{{ $delivey_days->id }}" id="delivery_day_id">
                    <div class="form-group checkbox">
                        <input type="checkbox" name="runBulk" id="confirmDeliveryCharge" value="{{ $delivey_days->id }}" required>
                        <label class="d-block" for="confirmDeliveryCharge" required>Confirm Delivery and Charge All Customers</label>
                    </div>
                    <button class="btn btn-primary btn-user" id="runBulkTran" type="submit">
                        <h4 class="mb-0">Run Bulk Transaction</h4></button>
                    {!! Form::close() !!}
                </div>
                @endif

                    @if($delivey_days->status == 'Completed')
                        <div class="offset-4 col-lg-4 col-md-12 confirm-delivery-chekbox">
                            <a target="_blank" href="{{route('admin.delivery_days.designer_report',$delivey_days->id)}}" class="btn btn-primary btn-user" id="DesignerReport">
                                <h4 class="mb-0">Designer Report</h4></a>
                        </div>

                        <div class="col-lg-4 col-md-12 confirm-delivery-chekbox">
                            <a target="_blank" href="{{route('admin.delivery_days.routes_labels', $delivey_days->id)}}" class="btn btn-primary btn-user" id="creatRoutes">
                                <h4 class="mb-0">Create Routes</h4></a>
                        </div>
                    @endif

            </div>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}" type="application/javascript"></script>
    <script>

        $("#faileddeliveries").click(function(){
            $("#allFailedDeliverShow").toggle();
        });
        $("#croos").click(function(){
            $("#allFailedDeliverShow").hide();
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#delivery_days').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print','pdf','excel','csv'
                ]
            } );
        } );
        let message = 'Your Message Will Show Here.';
        $(document).ready(function() {
            $('#delivery_days').DataTable();
        });

    </script>
    @include('flashy::message')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        function changeStatusCancel(elem){
            let cancelId = $(elem).data('cancelid');
            $.ajax({
                url: '{{ route('admin.delivery_days.canceled') }}',
                type: 'POST',
                data: {
                    cancelId:cancelId,
                    _token: '{{csrf_token()}}',
                },
                success: function(response) {
                    window.location.reload(true);
                },
                error: function(data) {}
            });
        }

        function searchResultsAJAX(elem) {
            $.post('{{ route('admin.delivery_days.index') }}', {
                _token: '{{ csrf_token() }}',
                search: $(elem).val(),
            }, function(data) {
                if (data['status'] == true) {$('#ajaxSearchResults').empty().append(data['view']);}
            });
        }

        $('.selectall').click(function() {
            if ($(this).is(':checked')) {
                $('.Checkbox-visible:checkbox').prop('checked', true);
            } else {
                $('.Checkbox-visible:checkbox').prop('checked', false);
            }
        });

        $("#runBulkTransections").validate({

            rules: {
                "runBulk": {
                    required: true,
                }
            },
            submitHandler: function(form) {
                return true;
            }
        });

        $('#cancelThisWeek').submit(function() {
            if ($('input:checkbox', this).length == $('input:checked', this).length ) {
            } else {
                alert('Please tick All Cancel This Week Checkboxe!');
                return false;
            }
        });
        $('#runBulkTransections').submit(function() {
            if ($('input:checkbox', this).length == $('input:checked', this).length ) {
                $(this).find('button').text('Please wait...');
                $(this).find('button').prop('disabled', true);
            } else {
                alert('Please tick Bulk Transection checkbox!');
                return false;
            }
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection
