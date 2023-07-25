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

        <!-- DataTales Example -->
        <div class="card shadow shadow mb-4 user-list p-4 dilevey_days">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-4">
                <h5>Delivery Days</h5>
            </div>
            <div class="border-1 delivery-main-area p-2 delivery-main">
                <div class="d-flex justify-content-between p-0">
                <ul class="nav nav-tabs buds-pills border-0 mt-3">
                    <li class=""><a data-toggle="tab" href="#UpcomingDeliveries" class="active">Upcoming Deliveries</a></li>
                    <li><a data-toggle="tab" href="#PendingDeliveries">Previous Deliveries</a></li>
                </ul>
                    <div class="d-flex justify-content-end p-1 mb-4">
                        <a class="btn btn-primary btn-user" href="{{ route('admin.delivery_days.create') }}">
                            <h4 class="mb-0">Create New Delivery</h4></a>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="UpcomingDeliveries" class="tab-pane fade in active show">
                        <table class="table table-bordered table-striped" id="delivery_days">
                            <thead>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total Delivery</th>
                            <th>Paid Deliveries</th>
                            <th>Unpaid Deliveries</th>
                            <th>Notes</th>
                            </thead>
                            <tbody id="ajaxSearchResults">
                            @if ($upcoming_devliverydays)
                                @foreach ($upcoming_devliverydays as $devliveryday)
                                    <tr role="row" class="even">
                                        <td>{{ $devliveryday->delivery_date }}</td>
                                        <td>{{ $devliveryday->status }}</td>
                                        <td>{{ $devliveryday->TotalDeliveries }}</td>
                                        <td>{{ $devliveryday->Paiddeliveries }}</td>
                                        <td>{{ $devliveryday->Faileddeliveries }}</td>
                                        <td class=" action">
                                            <a href="{{ route('admin.delivery_days.show', $devliveryday->id) }}">
                                                <button type="submit" data-title="Show" class="btn btn-circle btn-success text-white"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div id="PendingDeliveries" class="tab-pane fade">
                        <table class="table table-bordered table-striped" id="previous_delivery_days">
                            <thead>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total Delivery</th>
                            <th>Paid Deliveries</th>
                            <th>Unpaid Deliveries</th>
                            <th>Notes</th>
                            </thead>
                            <tbody id="ajaxSearchResults">
                            @if ($pending_devliverydays)
                                @foreach ($pending_devliverydays as $devliveryday)
                                    <tr role="row" class="even">
                                        <td>{{ $devliveryday->delivery_date }}</td>
                                        <td>{{ $devliveryday->status }}</td>
                                        <td>{{ $devliveryday->TotalDeliveries }}</td>
                                        <td>{{ $devliveryday->Paiddeliveries }}</td>
                                        <td>{{ $devliveryday->Faileddeliveries }}</td>
                                        <td class=" action">
                                            <a href="{{ route('admin.delivery_days.show', $devliveryday->id) }}">
                                                <button type="submit" data-title="Show" class="btn btn-circle btn-success text-white"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#delivery_days').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print','pdf','excel','csv'
                ]
            } );
        } );
        $(document).ready(function() {
            $('#previous_delivery_days').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print','pdf','excel','csv'
                ]
            } );
        } );
        // function deactivateCustomer(elem){
        //     $('#deactivateCustomer').modal('show');
        //     $("form#deactivatingCustomer input[name=user_id]").val($(elem).data('userid'));
        //     console.log($(elem),$(elem).data('userid'));
        // }


        let message = 'Your Message Will Show Here.';
        $(document).ready(function() {
            $('#delivery_days').DataTable();
        });

    </script>
    @include('flashy::message')

    <script>
        function searchResultsAJAX(elem) {
            $.post('{{ route('admin.delivery_days.index') }}', {
                _token: '{{ csrf_token() }}',
                search: $(elem).val(),
            }, function(data) {
                if (data['status'] == true) {$('#ajaxSearchResults').empty().append(data['view']);}
            });
        }



    </script>
@endsection
