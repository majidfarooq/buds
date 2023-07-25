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
    <div class="loading" style="display:none;">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
            <div></div>
        </div>
    </div>
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
                <h5>Routes</h5>
            </div>
            <div class=" p-2 delivery-main create_routes_main">
                <div class="card rounded-3 p-0">
                    <div class="row">
                    <div class="col-md-8 col-sm-12 px-4 py-4">
                        <form id="CreateRoutes">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                            <h2>Create Route</h2>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group mb-0 row">
                                    <label for="package_id" class="label col-md-4 col-sm-12">Delivery</label>
                                    <select class="form-control @error('delivery_day_id') is-invalid @enderror mb-2 col-md-8 col-sm-12" id="delivery_day_id" name="delivery_day_id">
                                        @if (isset($delivery_days))
                                         <option hidden value="0">Select</option>
                                            @foreach($delivery_days as $delivery_day)
                                                <option data-deliverydayId="{{$delivery_day->id}}" value="{{$delivery_day->id}}" {{isset($delivery_day->id) && $selected_delivery_day->id == $delivery_day->id ? 'selected' : ''}}>{{ \Carbon\Carbon::parse($delivery_day->delivery_date)->format('d/m/Y')}}
                                                </option>
                                            @endforeach
                                        @else
                                            <option hidden>None</option>
                                        @endif

                                    </select>
                                    @error('delivery_day_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="delivery-count d-flex justify-content-end form-group mb-0 row">
                                    <p>{{ $selected_delivery_day->TotalDeliveries }} Deliveries</p>
                                    <a class="view-all" target="_blank" href="{{ route('admin.delivery_days.show', $selected_delivery_day->id) }}">View all</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group mb-0 row">
                                    <label for="no_of_routes" class="label col-md-4 col-sm-12">No. of Routes</label>
                                    <input type="number" min="1" value="1" name="no_of_routes" id="no_of_routes" class="form-control @error('no_of_routes') is-invalid @enderror col-md-8 col-sm-12">
                                    @error('no_of_routes')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center p-1">
                                <button class="btn btn-primary btn-user" type="submit">Create Routes</button>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="col-md-4 col-sm-12 export-section px-4 py-4 disabled" id="export_routes">
                        <div class="col-12 mb-4">
                            <div class="d-flex">
                            <h2>Export Routes</h2>
                            </div>
                            <div class="d-flex" id="csvFiles">
                                <a href="#" class="csv-btn">CSV</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                            <h2>Export Labels</h2>
                                <a href="{{ route('admin.delivery_days.create_label_files', $selected_delivery_day->id) }}" class="pdf-btn">PDF</a>
                            </div>
                            <p>Exports one single PDF file for printing</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card-body p-0 card-delivery-main route-second-main col-md-8 col-sm-12">
                    <div class="col-12">
                        <h2>Routes History
                        </h2>
                    </div>
{{--                    <div class="table-responsive user-package delivery-section">--}}
{{--                        <table class="table table-bordered table-striped" id="delivery_days">--}}
{{--                            <thead>--}}
{{--                            <th>No. of--}}
{{--                                Routes</th>--}}
{{--                            <th>Delivery</th>--}}
{{--                            <th>Customers</th>--}}
{{--                            <th>CSV</th>--}}
{{--                            <th>Labels</th>--}}
{{--                            </thead>--}}
{{--                            <tbody id="ajaxSearchResults">--}}
{{--                            @if ($devliverydays)--}}
{{--                                @foreach ($devliverydays as $devliveryday)--}}
{{--                                    <tr role="row" class="even">--}}
{{--                                        <td></td>--}}
{{--                                        <td>{{ $devliveryday->delivery_date }}</td>--}}
{{--                                        <td>{{ $devliveryday->status }}</td>--}}
{{--                                        <td>{{ $devliveryday->TotalDeliveries }}</td>--}}
{{--                                        <td>{{ $devliveryday->Paiddeliveries }}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    @include('flashy::message')
    <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}"
            type="application/javascript"></script>
    <script src="{{ asset('public/assets/backend/js/additional-methods.min.js') }}"
            type="application/javascript"></script>

    <script>

         $('#CreateRoutes').on('submit', function(e){
             e.preventDefault();
               var deliverydayId = $(this).find(':selected').data('deliverydayid');
               var no_of_routes = $("#no_of_routes").val();
                 if (no_of_routes == "")
                 {
                     alert("Please input a No. of Routes");
                     return false;
                 }
                 $('.loading').css('display','block');
             $.ajax({
                 type: 'POST',
                 url: '{{ route('admin.delivery_days.get_routes_labels_files') }}',
                 data: {
                     deliverydayId: deliverydayId,
                     no_of_routes: no_of_routes,
                     "_token": "{{ csrf_token() }}",
                 },
                 success: function(response)
                 {
                     console.log(response.routes_labels)
                     // $('#csvFiles').html('');
                     $cntr = 1;
                     content ='';
                     jQuery.each(response.routes_labels.route_files, function(index, item) {
                         var Url = item.split('/')
                         var fileName = Url[Url.length - 1]
                         console.log(fileName);
                         var flagsUrl = '{{ URL::asset('storage/app/public/csv/') }}/'+fileName;
                         content +='<a target="_blank" href="' +flagsUrl+ '" class="csv-btn">';
                         content +='Route '+$cntr+'';
                         content +='</a>';
                         $cntr++;
                     });
                     $('#csvFiles').html(content)

                     $('.loading').css('display','none')
                     $('#export_routes').removeClass('disabled');
                 },
                 error: function(error)
                 {
                     $('.loading').css('display','none');
                 }
             });

        });

        $("#delivery_day_id").change(function() {
            window.location.href = $(this).val();
        });
        let message = 'Your Message Will Show Here.';
        $(document).ready(function() {
            $('#delivery_days').DataTable();
        });

    </script>
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
