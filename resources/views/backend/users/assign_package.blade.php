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
            <div class="card-header py-3">
                <h5 class="m-0 mb-4 text-primary">Add Subscription</h5>
                <p class="mb-2">{{$user->first_name}} <span>{{$user->last_name}}</span></p>
                <p class="mb-2">{{$user->phone}} </p>
                <p class="mb-2">{{$user->email}}</p>
            </div>
            <div class="card-body row">
                <div class="col-12 p-0">
                    {!! Form::open(["route" => ["admin.users.assign_package_submission"],"id"=>"userAssignCreate", "files"=> true,"class"=>"w-100","method"=>"Post"]) !!}
                     <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="card rounded-3 p-0">
                            <div class="row align-items-end">
                                <div class="col-lg-6 col-md-12">
                                    <h2>Assign a Package</h2>
                                    <div class="form-group ">
                                        <label for="package_id" class="label d-none">Assign a Package</label>
                                        <select class="form-control @error('package_id') is-invalid @enderror" name="package_id" id="package_id" required="required">
                                            <option disabled selected>Select a Package</option> @foreach ($packages as $package)
                                                <option data-packageId="{{$package->id}}" value="{{$package->id}}">{{$package->title}}</option> @endforeach
                                        </select>
                                        @error('package_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-12 delivery-text">
                                    <div id="packageTotalRate">
                                        <h1>$ 00.00/<span>Delivery</span></h1>
                                    </div>
                                </div>
                                <div class="col form-group col-lg-3 col-md-12">
                                    <label for="delivery_frequence" class="label d-none">Select a Package</label>
                                    <select class="form-control @error('delivery_frequence') is-invalid @enderror" name="type" id="delivery_frequence" required="required">
                                        <option disabled selected>Delivery Frequence</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="bi-monthly">Bi-Monthly</option>
                                    </select>
                                    @error('delivery_frequence') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                </div>
                            </div>
                            <div class="row align-items-center ">
                                <div class="col form-group col-lg-2 col-md-12 my-4">
                                    <h4 class="mb-0">Select Delivery</h4> </div>
                                <div class="col col-lg-10 col-md-12 d-flex align-items-center my-4">
                                    <div class="form-check mr-5">
                                        <input class="form-check-input" type="radio" name="day" id="Thursday" value="thursday">
                                        <label class="form-check-label" for="Thursday"> Regular </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="day" id="Friday" value="friday" checked>
                                        <label class="form-check-label" for="Friday"> Custom </label>
                                    </div>
                                    @error('day') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                                </div>
                                <div class="col form-group ">
                                    <label for="DeliveryNotes" class="">Delivery Notes</label>
                                    <textarea id="DeliveryNotes" name="description" rows="4" class="form-control"></textarea>
                                    @error('description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="my-4">Payment Method  </h5>
                                <div class="card-body col-lg-9 col-md-12 mx-auto">
                                    <div class="col-12 my-4" id="paymenMethodAssign">
                                        <div class="form-check my-4">
                                            <input class="form-check-input radioButtons" id="collectCashRadio" type="radio" name="paid_via" value="other" checked>
                                            <label class="form-check-label" for="collectCashRadio"> Collect Cash / Check (Credits) </label>
                                        </div>
                                        <div class="form-check my-4 mb-5">
                                            <input class="form-check-input radioButtons" id="subscribeCredit" type="radio" name="paid_via"  value="cc">
                                            <label class="form-check-label" for="subscribeCredit"> Subscribe by Credit / Debit Card </label>
                                        </div>
                                        @error('payment_type') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                    </div>
                                </div>
                                <div class="mx-auto col-lg-5 col-md-10 col-sm-12 p-0" id="subscribeCard" style="display: none;">
                                    @if(!empty($defaultPayment))
                                        <div class="form-check my-4">
                                            <input data-type="default_payment" class="form-check-input" name="card_default_payment_id" id="defaultGateway" type="radio" value="other" checked>
                                            <label class="form-check-label" for="defaultGateway"> <img alt="Admin Photo" width="40px" id="current_Image"
                                                                                                         class="img-profile"
                                                                                                         src="{{ asset('public/assets/backend/img/'.$defaultPayment->card->brand.'.png') }}"
                                                                                                         alt="amherst"> ************{{$defaultPayment->card->last4}} / {{$defaultPayment->card->brand}} ({{$defaultPayment->card->exp_month}}/{{$defaultPayment->card->exp_year}}) </label>
                                        </div>
                                     @else
                                    <div class="form-row payment-form-add">
                                        <div class="inner-form-card">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element"></div>
                                            <input type="hidden" name="stripeToken" id="stripeToken" value="">
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="offset-lg-1 col-lg-10 col-md-12 p-0" id="collectCash">
                                    <div class="row">
                                        <div class="offset-lg-3 col-lg-2 col-md-12">
                                            <div class="form-outline form-group">
                                                <label class="form-label" for="quantity">Enter Number of Payments</label>
                                                <input type="number" min="1" id="quantity" name="quantity" class="form-control form-control-lg number-payment @error('quantity') is-invalid @enderror" required>
                                                @error('quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror

                                            </div>
                                        </div>
                                        <div class="delivery-text col-lg-3 col-md-12">
                                            <div id="amount">
                                                @error('amount') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                            </div>
                                            <div id="numberOfPayments">
                                                <h1>$ 00.00</h1>
                                            </div>
                                        </div>
                                        <div class="NextPayment-text col-lg-3 col-md-12">
                                        </div>
                                    </div>
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
                                                <input type="text" id="Disposition" name="payment_description" class="form-control form-control-lg">
                                                @error('payment_description') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
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

                        <div class="col-12 text-center subscribe-btn my-4 pt-5">
                            <button id="ProceedWithToken" class="btn btn-primary text-white" type="submit">Proceed</button>
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
        card.mount('#card-element');
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('userAssignCreate');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

        });
        $('#ProceedWithToken').click(function () {
            var chk = $('#paymenMethodAssign input:radio:checked');
            if(chk.attr('value') =='cc'){
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        $('#stripeToken').val(result.token.id)
                        $("#userAssignCreate").submit();
                    }
                });
            }else{
                $("#userAssignCreate").submit();
            }

            // var chk = $('#paymenMethodAssign input:radio:checked');
            //
            // if(chk.attr('value')=='cc'){
            //     stripe.createToken(card).then(function(result) {
            //         if (result.error) {
            //             var errorElement = document.getElementById('card-errors');
            //             errorElement.textContent = result.error.message;
            //         } else {
            //             $('#stripeToken').val(result.token.id)
            //             $("#userAssignCreate").submit();
            //         }
            //     });
            // }else{
            //     $("#userAssignCreate").submit();
            // }

        });


        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form-add');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
        function checkMethod(elem){
            $(elem).val('')
        }
    </script>
<script>
    $('#package_id').change(function(e) {
        e.preventDefault();
        var packageId = $(this).find(':selected').data('packageid');
        $.ajax({
            type: "POST",
            url: "{{ route('admin.users.package_detail') }}",
            data: {
                packageId: packageId,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log(response.packages.amount)
                $('#packageTotalRate').html('<h1 class="card-title">$ ' + response.packages.amount + '/<span>Delivery</span></h1>')
            },
            error: function(data) {}
        });
    });

    $('#quantity').change(function() {
        // e.preventDefault();
        var amount = $("#packageTotalRate").text();
        var amount = parseFloat(amount.replace('/Delivery', '').replace('$', ''));
        if(amount == 0) {
            alert('Please Select a package first')
        } else {
            var payableAmount = amount * parseFloat(this.value).toFixed(2);
        }
        if(payableAmount == null) {
            $('#numberOfPayments').html('<h1 class="card-title">$ 00.00</h1>');
            $('#amount').html('<input type="hidden" name="amount" id="amount" value="0">');

        } else {
            $('#numberOfPayments').html('<h1 class="card-title">$ ' + payableAmount + '</h1>');
            $('#amount').html('<input type="hidden" name="amount" id="amount" value="' + payableAmount + '">');
        }
    });


    $('input:radio[name="paid_via"]').change(
        function(){
            if ($(this).is(':checked') && $(this).val() == 'other') {
                $("#collectCash").css("display", "block");
                $("#subscribeCard").css("display", "none");
                $("#subscribeCardListing").css("display", "none");
            }else{
                $("#subscribeCardListing").css("display", "block");
                $("#subscribeCard").css("display", "block");
                $("#collectCash").css("display", "none");
            }
        });

    $("#userAssignCreate").validate({
        rules: {
            "package_id": {
                required: true,
            },
            "delivery_frequence": {
                required: true,
            },
            "quantity": {
                required: true,
            },
            "amount": {
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
