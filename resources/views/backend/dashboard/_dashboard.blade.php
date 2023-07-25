@extends('backend.layouts.app')

@section('style')

@endsection

@section('content')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card border-0 p-5 dashboard-section">
                <h5 class="text-center mb-5">Dashboard</h5>
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Deliveries <strong>This</strong> week
                                                mm-dd-yy to mm-dd-yy</p></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="green-text"><h3>{{$data['delivery_count_current_week']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Deliveries <strong>Past</strong> week
                                                mm-dd-yy to mm-dd-yy</p></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['delivery_count_last_week']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Current total <strong>Subscription</strong></p></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['total_subscriptions']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Change in Subscribers This Month</p></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['subscriber_this_month']}} </h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This <strong>Month</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="green-text"><h3>$<strong>{{$data['total_revenue_this_month']}}</strong></h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This <strong>Week</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="green-text"><h3>$<strong>{{$data['total_revenue_this_week']}}</strong></h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Receivable Next <strong>Week</strong> </p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class=""><h3>$<strong>{{$data['unpaid_delivery_amount_this_week']}}</strong></h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Anticipated Revenue Next <strong>Month</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class=""><h3>$<strong>{{$data['unpaid_delivery_amount_this_month']}}</strong></h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                    <div class="">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This Year</p></div>
                                    </div>
                                    <div class="">
                                        <div class="green-text"><h3>$ 100,000.00</h3></div>
                                    </div>
                                </div>
                                <canvas id="myChart" height="300px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                    <div class="">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Due Till-Date</p></div>
                                    </div>
                                    <div class="">
                                        <div class="red-text"><h3>$ 100,000.00</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('script')

    @include('flashy::message')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script> </script>
{{--    <script type="text/javascript">--}}

{{--        var labels =  {{ Js::from($labels) }};--}}
{{--        var users =  {{ Js::from($data) }};--}}

{{--        const data = {--}}
{{--            labels: labels,--}}
{{--            datasets: [{--}}
{{--                label: 'My First dataset',--}}
{{--                backgroundColor: 'rgb(255, 99, 132)',--}}
{{--                borderColor: 'rgb(255, 99, 132)',--}}
{{--                data: users,--}}
{{--            }]--}}
{{--        };--}}

{{--        const config = {--}}
{{--            type: 'line',--}}
{{--            data: data,--}}
{{--            options: {}--}}
{{--        };--}}

{{--        const myChart = new Chart(--}}
{{--            document.getElementById('myChart'),--}}
{{--            config--}}
{{--        );--}}

{{--    </script>--}}
@endsection

