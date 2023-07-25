@extends('backend.layouts.app') @section('style')
    <style type="text/css">
        td.action {
            display: flex;
            gap: 10px;
        }

        [data-title]:hover:after {
            opacity: 1;
            transition: all 0.1s ease 0.5s;
            visibility: visible;
        }

        [data-title]:after {
            content: attr(data-title);
            background-color: #f8f9fc;
            color: #4e73df;
            font-size: 15px;
            position: absolute;
            padding: 1px 5px 2px 5px;
            top: -35px;
            left: 0;
            white-space: nowrap;
            box-shadow: 1px 1px 3px #4e73df;
            opacity: 0;
            border: 1px solid #4e73df;
            z-index: 99999;
            visibility: hidden;
        }

        [data-title] {
            position: relative;
        }
    </style> @endsection @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0"> @if ($message = \Illuminate\Support\Facades\Session::get('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong> </div> @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong> </div> @endif </div>
        </div>
        <!--end col-->
    </div>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow p-4 mb-4">
            <div class="row">
                <div class="col-lg-7 col-md-12 p-0">
                    <div class="card-header py-3 pb-0 charles-text">
                        <p class="mb-2">Charles Dawson <span>Hernandez</span></p>
                        <p class="mb-2">(416) 619-4411 </p>
                        <p class="mb-2">longemailaddress@longdomain.com</p>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    @if ($UserPackage)
                        <div class="row user_subscription mb-3">
                            <div class="col-3"><label class="small">Package</label> <p> {{ $UserPackage->package->title}}</p></div>
                            <div class="col-3"><label class="small">Amount</label> <p> ${{  number_format($UserPackage->package->amount, 2, ".", ",")}}</p></div>
                            <div class="col-3"><label class="small">Delivery</label> <p> {{$UserPackage->type}}</p></div>
                            <div class="col-3"><label class="small">Since</label> <p>{{ \Carbon\Carbon::parse($UserPackage->created_at)->format('j M Y') }}</p></div>
                            <div class="col-4 dollar-section">
                                <a href="{{ route('admin.users.assign_total_credits', $UserPackage->id) }}"><label class="small">Total Credits
                                        @if ($UserPackage->remaining_deliveries < 0)
                                            <img src="{{asset('/public/assets/backend/img/dollar-cancel.png')}}">
                                        @else ($UserPackage->remaining_deliveries )
                                            <img src="{{asset('/public/assets/backend/img/dollar-succes.png')}}">
                                        @endif
                                    </label>
                                </a>
                            </div>
                            @if ($UserPackage->remaining_deliveries < 0)
                            <div class="col-4 assign-red"><label class="small">({{$UserPackage->remaining_deliveries}} Payments)</label></div>
                            <div class="col-4 rate-section assign-red"><label class="small">${{ number_format($UserPackage->remaining_deliveries * $UserPackage->package->amount, 2, ".", ",")}}</label></div>
                            @else ($UserPackage->remaining_deliveries )
                                <div class="col-4"><label class="small">({{$UserPackage->remaining_deliveries}} Payments)</label></div>
                                <div class="col-4"><label class="small">${{ number_format($UserPackage->remaining_deliveries * $UserPackage->package->amount, 2, ".", ",")}}</label></div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body row">
                <div class="col-12 p-0">
                    {!! Form::open(["route" => ["admin.users.assign_package_payments"],"id"=>"userAssignPayment", "files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
                    <input type="hidden" name="user_package_id" value="{{$UserPackage->id}}">
                    <input type="hidden" name="package_unit_price" value="{{ $UserPackage->package->amount}}" id="package_unit_price">
                    <input type="hidden" name="amount" value="{{ $UserPackage->package->amount}}" id="amount">
                    <input type="hidden" name="stripeToken" id="stripeToken" value="">
                    <input type="hidden" name="user_id" value="{{$UserPackage->user->id}}">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="my-4">Pay-Off </h5>
                            <div class="row align-items-end">
                                <div class="col-lg-2 col-md-12">
                                    <div class="form-outline form-group">
                                        <label class="form-label" for="quantity">Enter Number of Payments</label>
                                        <input type="number" id="quantity" min="1" value="@if($UserPackage->remaining_deliveries < 0){{abs($UserPackage->remaining_deliveries)}}@else($UserPackage->remaining_deliveries ){{1}}@endif" name="quantity" class="form-control form-control-lg number-payment " required="">
                                    </div>
                                </div>
                                <div class="delivery-text col-lg-3 col-md-12">
                                    <div id="amount">
                                    </div>
                                    <div id="numberOfPayments">
                                        <h1>${{  number_format($UserPackage->package->amount, 2, ".", ",")}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div id="paymenMethod">
                            <div class="card-body col-lg-9 col-md-12 mx-auto">
                                <div class="col-12 my-4">
                                    <div class="form-check my-4">
                                        <input class="form-check-input radioButtons" id="collectCashRadio" type="radio" name="type" value="other" checked>
                                        <label class="form-check-label" for="collectCashRadio"> Collect Cash / Check (Credits) </label>
                                    </div>
                                    <div class="form-check my-4 mb-5">
                                        <input class="form-check-input radioButtons" id="subscribeCredit" type="radio" name="type"  value="cc">
                                        <label class="form-check-label" for="subscribeCredit"> Subscribe by Credit / Debit Card </label>
                                    </div>
                                    @error('payment_type') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                </div>
                            </div>
                            <div class="mx-auto col-lg-5 col-md-10 col-sm-12 p-0 select_card_type" id="subscribeCard" style="display: none;">
                                @if(isset($paymentMethods) && !empty($paymentMethods))
                                    @foreach($paymentMethods->data as $card)
                                        <div class="form-check my-4">
                                            <input data-type="saved_card"  class="form-check-input " id="card_{{$card->id}}" name="card_default_payment_id" type="radio" value="{{$card->id}}" >
                                            <label class="form-check-label" for="card_{{$card->id}}">
                                                <img alt="Admin Photo" width="40px" id="current_Image" class="img-profile" src="{{ asset('public/assets/backend/img/'.$card->card->brand.'.png') }}"
                                                     alt="amherst"> ************{{$card->card->last4}} / {{$card->card->brand}} ({{$card->card->exp_month}}/{{$card->card->exp_year}}) </label>
                                        </div>
                                    @endforeach
                                    <div class="form-check my-4">
                                        <input  class="form-check-input" id="card_type2" name="card_default_payment_id" value="new_card" type="radio" >
                                        <label class="form-check-label" for="card_type2">Enter a New Credit / Debit Card </label>
                                    </div>
                                    <div class="form-row payment-form-add" id="newPaymentCard" style="display: none">
                                        <div class="inner-form-card">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row payment-form-add">
                                        <div class="inner-form-card">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="offset-lg-1 col-lg-10 col-md-12 p-0" id="collectCash">
                                <div class="row">
                                    <div class="col-lg-2 col-md-12">
                                        <div class="form-outline form-group">
                                            <label class="form-label" for="payment_date">Payment Date</label>
                                            <input type="date" id="payment_date" name="payment_date" class="form-control form-control-lg @error('payment_date') is-invalid @enderror" required>
                                            @error('payment_date') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-outline form-group">
                                            <label class="form-label" for="Disposition">Disposition</label>
                                            <input type="text" id="description" name="description" class="form-control form-control-lg">
                                            @error('description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                        </div>
                                    </div>
                                    <div class="delivery-text col-lg-2 col-md-12">
                                        <div class="form-outline form-group">
                                            <label class="form-label" for="TransactionID">Transaction ID</label>
                                            <input type="text" id="TransactionID" name="transection_id" class="form-control form-control-lg">
                                            @error('transection_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                                        </div>
                                    </div>
                                    <div class="delivery-text col-lg-1 col-md-12">
                                        <div class="form-outline form-group">
                                            <label class="form-label" for="Atachment">Atachment</label>
                                            <input type="file" id="Atachment" name="attachment" class="form-control form-control-lg">
                                            @error('attachment') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center subscribe-btn my-4 pt-5">
                        <button id="PrceedWithToken" class="btn btn-primary text-white" type="submit">Proceed</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('flashy::message')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('public/assets/backend/js/jquery.validate.min.js') }}" type="application/javascript"></script>
    <script type="application/javascript">

        document.getElementById('payment_date').valueAsDate = new Date();
        var stripe = Stripe('pk_test_P6rZrxopN6TvH3DdvwFH8JhE');
        var elements = stripe.elements();
        var card = elements.create('card', {
            hidePostalCode: true,
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        card.mount('#card-element');
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('userAssignPayment');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
        });
        $('#PrceedWithToken').click(function () {
            var chk = $('#paymenMethod input:radio:checked');
            if(chk.attr('value')=='other'){
                $("#userAssignPayment").submit();
            } else {
                if ($('#card_type2').is(':checked')) {
                    stripe.createToken(card).then(function(result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            $('#stripeToken').val(result.token.id)
                            $("#userAssignPayment").submit();
                        }
                    });
                }else{
                    $("#userAssignPayment").submit();
                }
            }
        })

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form-add');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }

    </script>
    <script>
        $(document).ready(function(){
            $('.select_card_type input[type=radio]').change(function(){
                // alert('here');data-type="saved_card"
                var type = $(this).data("type");
                if(type === "saved_card"){
                    $('#newPaymentCard').hide();
                }else{
                    $('#newPaymentCard').show();
                }
            });

            var amount = $('#package_unit_price').val();
            var quantity = $('#quantity').val();
            var payableAmount = amount * quantity;

            $('#amount').val(payableAmount);
            $('#numberOfPayments').html('<h1 class="card-title">$' + payableAmount + '</h1>');
        });


        $('#quantity').change(function() {
            var amount = $('#package_unit_price').val();
            // alert(amount);
            if(amount == 0) {
                alert('Please Select a package first')
            } else {
                var payableAmount = amount * parseFloat(this.value).toFixed(2);
            }
            $('#amount').val(payableAmount);
            $('#numberOfPayments').html('<h1 class="card-title">$' + payableAmount + '</h1>');

        });

        $('input:radio[name="type"]').change(
            function(){
                if ($(this).is(':checked') && $(this).val() == 'other') {
                    $("#collectCash").css("display", "block");
                    $("#subscribeCard").css("display", "none");

                }else{
                    $("#subscribeCard").css("display", "block");
                    $("#collectCash").css("display", "none");

                }
            });

        $("#userAssignPayment").validate({
            rules: {
                "quantity": {
                    required: true,
                },
                "payment_date": {
                    required: true,
                }
            },
            submitHandler: function(form) {
                return true;
            }
        });

    </script> @endsection
