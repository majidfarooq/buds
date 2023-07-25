@extends('backend.layouts.app')
@section('style')
    <style type="text/css">
        td.action {display: flex ; gap: 10px;}

        [data-title]:hover:after {opacity: 1 ; transition: all 0.1s ease 0.5s ; visibility: visible;}
        [data-title]:after {
            content: attr(data-title) ; background-color: #f8f9fc ; color: #4e73df ; font-size: 15px ; position: absolute ; padding: 1px 5px 2px 5px ; top: -35px ; left: 0 ; white-space: nowrap ; box-shadow: 1px 1px 3px #4e73df ; opacity: 0 ; border: 1px solid #4e73df ; z-index: 99999 ; visibility: hidden;
        }
        [data-title] {position: relative;}
        .delivery-section label {
            display: block;
            float: right;
        }
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
            <div class="d-flex pt-3 pb-4 delivery-confirmation">
                <h5>Delivery Confirmation
                </h5>
                <h3 class="date mx-4">{{ \Carbon\Carbon::parse($selected_delivery_day->delivery_date)->format('j M Y') }}</h3>
            </div>
            <div class="border-1 delivery-main-area p-2 delivery-main designer-report-card">
                <div class="card-body p-0 card-delivery-main mx-5">
                    <div class="d-flex designer-counter">
                        <h3>Designer Report</h3>
                        @php $first_active = true @endphp
                        <ul class="nav nav-tabs ml-0 designer-report-btn">
                            <li class="nav-item">
                                <a class="nav-link btn btn-default" onclick="shortlist_deliveries('')" >All ({{ $all_deliveries->count()}})</a>
                            </li>
                            @php $top_message =''; @endphp
                            @php $pdf_message =''; @endphp
                            @foreach ($package_types as $pType)
                            @php $top_message .=$pType.' ('.$deliveries[$pType]['count'].')  \n\r'; @endphp
                            @php $pdf_message .=$pType.'('.$deliveries[$pType]['count'].')              '; @endphp
                                <li class="nav-item">
                                <a class="nav-link btn btn-default"  role="tab" onclick="shortlist_deliveries('{{$pType}}')" >{{$pType}} ({{$deliveries[$pType]['count']}}) </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>

                    <div class="table-responsive user-package delivery-section">

                        <table class="table table-bordered table-striped" id="desinger_reports_table_Standard">
                            <thead>
                                <th>Name</th>
                                <th>Package</th>
                                <th>Package Type</th>
                                <th>Contact</th>
                                <th>City/ Area</th>
                                <th>Amount</th>
                            </thead>
                            <tbody id="ajaxSearchResults">
                            @foreach ($all_deliveries as $delivery)
                                <tr role="row" class="even">
                                    @php  $encrypted=\App\Http\Controllers\backend\AdminController::makeEncryption($delivery->id)  @endphp
                                    <td>{{ $delivery->user_package->user->first_name }}{{ $delivery->user_package->user->last_name }}</td>
                                    <td>{{ $delivery->user_package->package->title }}</td>
                                    <td>{{ $delivery->user_package->package->type }}</td>
                                    <td>{{$delivery->user_package->user->business_name}} <br> {{$delivery->user_package->user->recipient_name}}<br> {{$delivery->user_package->user->recipient_phone}}</td>
                                    <td>{{ $delivery->user_package->user->delivery_zip . ' '.$delivery->user_package->user->delivery_address1}} <br>{{ $delivery->user_package->user->delivery_address2 . ' '.$delivery->user_package->user->delivery_city}}</td>
                                    <td>${{  number_format($delivery->user_package->package->amount, 2, ".", ",")}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>

        $(document).ready(function() {
            var pdf_txt= '{{$pdf_message}}'
            var top_txt= '{{$top_message}}'
            oTable = $('#desinger_reports_table_Standard').DataTable( {
                paging: false,
                dom: 'Bfrtip',
                buttons: [
                     {
                         extend: 'excel', messageTop:top_txt,
                         text:      'Excel',
                         title:'Designer Report',
                         titleAttr: 'Excel',
                         className: 'btn btn-app export excel',
                         exportOptions: {
                             columns: [ 0, 1, 2, 3, 4, 5 ]
                         },
                    },

                    {
                        extend: 'print',messageTop:top_txt,
                        text:      'Print',
                        title:'Designer Report',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-app export imprimir',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'pdf',messageTop:pdf_txt,
                        text:      'PDF',
                        title:'Designer Report',
                        titleAttr: 'PDF',
                        className: 'btn btn-app export pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        },
                        customize:function(doc) {
                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '30',
                                alignment: 'center'
                            },
                                doc.styles.className = {
                                    fontSize: '30',
                                    float:'left',
                                    alignment: 'center',
                                    marginBottom: '40',
                                },
                                doc.styles.tableHeader = {
                                    fillColor:'#4c8aa0',
                                    color:'white',
                                    alignment:'center'
                                },
                                doc.content[1].margin = [ 20, 20, 20, 20 ]
                        }
                    },
                    {
                        extend: 'csv', messageTop:top_txt,
                        text:      'CSV',
                        title:'Designer Report',
                        titleAttr: 'CSV',
                        className: 'btn btn-app export csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    }
                ]
            } );

        } );

        let message = 'Your Message Will Show Here.';
        $(document).ready(function() {
            $('#desinger_reports_table').DataTable();
        });

    </script>
    @include('flashy::message')
     <script>
        function shortlist_deliveries(elem) {
            oTable.search(elem).draw() ;
        }
    </script>

@endsection
