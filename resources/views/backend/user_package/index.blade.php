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
        <div class="card shadow shadow mb-4 user-list p-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-4">
                <h5>Subscriptions</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive user-package">
                    <table class="table table-bordered table-striped" id="user_packages">
                        <thead>
                        <th>id</th>
                        <th>Name</th>
                        <th>Package</th>
                        <th>Contact</th>
                        <th>Delivery Address</th>
                        <th>Status</th>
                        <th>Subscription Date</th>
                        <th>Credit Balance</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="ajaxSearchResults">
                        @if ($user_packages)
                            @foreach ($user_packages as $user_package)
                                <tr role="row" class="even">
                                    @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($user_package->id)  @endphp
                                    <td>{{ $user_package->id }}</td>
                                    <td>{{ $user_package->user->first_name . ' ' . $user_package->user->last_name }}</td>
                                    <td>{{ $user_package->package->title }} <br>{{$user_package->type}}</td>

                                    <td> {{ $user_package->user->email }}, <br> {{ $user_package->user->phone }}</td>
                                    <td>{{ $user_package->user->delivery_address1 . ', '.$user_package->user->delivery_address2}}, <br>{{ $user_package->user->delivery_zip . ', '.$user_package->user->delivery_city}} </td>
                                    <td>{{ $user_package->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user_package->created_at)->format('j M Y') }}</td>
                                    <td>
                                        @if ($user_package->remaining_deliveries < 0)
                                            <span class="red-text">
                                            Deliveries:
                                            {{ $user_package->remaining_deliveries }}<br> Amount: {{  number_format($user_package->remaining_deliveries * $user_package->package->amount, 2, ".", ",")}}
                                            </span>
                                        @else
                                            Deliveries:
                                            {{ $user_package->remaining_deliveries }}<br> Amount: {{  number_format($user_package->remaining_deliveries * $user_package->package->amount, 2, ".", ",")}}
                                        @endif
                                    </td>
                                    <td class=" action">
                                         <a href="{{ route('admin.user_packages.show', $user_package->id) }}">
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

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#user_packages').DataTable( {
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
            $('#packages').DataTable();
        });

    </script>
    @include('flashy::message')

    <script>
        function searchResultsAJAX(elem) {
            $.post('{{ route('admin.user_packages.index') }}', {
                _token: '{{ csrf_token() }}',
                search: $(elem).val(),
            }, function(data) {
                if (data['status'] == true) {$('#ajaxSearchResults').empty().append(data['view']);}
            });
        }



    </script>
@endsection
