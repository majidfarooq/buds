@extends('backend.layouts.app')

@section('style')

@endsection

@section('content')
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card border-0 p-5 dashboard-section">
                <h5 class="text-center mb-5">Dashboard
                    <a  href="{{route('admin.delivery_days.index')}}" class="btn btn-primary btn-user" style="float: right">All Delivery Days</a>
                </h5>
                <div class="row mb-5 dashboard-section-main">
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Deliveries <strong>This</strong> week
                                                mm-dd-yy to mm-dd-yy</p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="green-text"><h3>{{$data['delivery_count_current_week']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Deliveries <strong>Past</strong> week
                                                mm-dd-yy to mm-dd-yy</p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['delivery_count_last_week']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Current total <strong>Subscription</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['total_subscriptions']}}</h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Change in Subscribers This Month</p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><h3>{{$data['subscriber_this_month']}} </h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This <strong>Month</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="green-text"><h3><strong>@currency_format($data['total_revenue_this_month'])</strong></h3></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This <strong>Week</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class="green-text"><h3><strong>@currency_format($data['total_revenue_this_week'])</strong></h3></div>
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
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Deliveries This <strong>Month</strong> </p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class=""><h3>
                                                <strong>$
                                                    {{  number_format($data['unpaid_delivery_amount_this_month'] + $data['paid_delivery_amount_this_month']+$data['recieveable_delivery_amount_this_month'], 2, ".", ",")}}
                                                </strong>
                                            </h3></div>

                                    <div>
                                        <canvas id="month_pieChart"></canvas>
                                    </div>
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
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total deliveries This <strong>Week</strong></p></div>
                                    </div>
                                    <div class="col-auto w-100">
                                        <div class=""><h3><strong>$
                                                    {{  number_format($data['unpaid_delivery_amount_this_week'] + $data['paid_delivery_amount_this_week']+$data['recieveable_delivery_amount_this_week'], 2, ".", ",")}}
                                                </strong></h3></div>
                                         <div><canvas id="week_pieChart"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><p>Total Revenue This Year</p></div>
                                    </div>
                                    <div class="">
                                        <div class="green-text"><h3>@currency_format($data['revenue_group_by_month']['total_amount'])</h3></div>
                                    </div>
                                </div>
                                <canvas id="myChart" class="total-revenue-this-year" height="300px"></canvas>
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

    <script>
        // Monthly Total Revenue Chart
        const mtr = document.getElementById('myChart');
        var data_labels='{{$data['revenue_group_by_month']['x']}}'.split(",")
        var data_values='{{$data['revenue_group_by_month']['y']}}'.split(",")
        console.log(data_labels,data_values);
        new Chart(mtr, {
            type: 'bar',
            data: {
            labels:data_labels  ,
            datasets: [{
                label: 'Total Revenue',
                data: data_values,
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });

        const tmd = document.getElementById('month_pieChart');
        new Chart(tmd, {
            type: 'pie',
            data: {
            labels:[ 'Paid','Unpaid','Pending']  ,
            datasets: [{
                label: 'Current Month Deliveries',
                data: ['{{$data['paid_delivery_amount_this_month']}}','{{$data['unpaid_delivery_amount_this_month']}}','{{$data['recieveable_delivery_amount_this_month']}}'],

            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });

        const twd = document.getElementById('week_pieChart');
        new Chart(twd, {
            type: 'pie',
            data: {
            labels:[ 'Paid','Unpaid','Pending']  ,
            datasets: [{
                label: 'Current Month Deliveries',
                data: ['{{$data['paid_delivery_amount_this_week']}}','{{$data['unpaid_delivery_amount_this_week']}}','{{$data['recieveable_delivery_amount_this_week']}}'],

            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });

    </script>
@endsection

