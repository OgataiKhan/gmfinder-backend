@extends('layouts.admin')
@section('content')
<form id="payment-form" name="payment-form" action="{{ route('makePayment') }}" method="POST">

    @csrf




    <!-- includes the Braintree JS client SDK -->
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>


    <div id="dropin-wrapper">

        <div id="checkout-message"></div>
        <div id="dropin-container"></div>

        <button class="" id="submit-button">Submit payment</button>

    </div>
    <script>
        var button = document.querySelector('#submit-button');
            var latestPromotion = {!! json_encode($latestPromotion) !!};
            var token = {!! json_encode($token) !!};
            let loading = false;

            braintree.dropin.create({
                // Insert your tokenization key here
                authorization: 'sandbox_q7nymv9j_x836p3xfjx89884d',
                container: '#dropin-container'
            }, function(createErr, instance) {
                button.addEventListener('click', function() {
                    instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                        // When the user clicks on the 'Submit payment' button this code will send the
                        // encrypted payment information in a variable called a payment method nonce
                        loading = true;
                        if(loading===true){
                          $('#loader').removeClass('d-none');
                          $('#dropin-wrapper').addClass('d-none');
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'http://127.0.0.1:8000/api/payments/make/payment',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: {
                                "paymentMethodNonce": payload.nonce,
                                "token": token,
                                "promotion": latestPromotion
                            }
                        }).done(function(result) {
                            loading=false;
                            
                            instance.teardown(function(teardownErr) {
                                if (teardownErr) {
                                    console.error('Could not tear down Drop-in UI!');
                                } else {
                                    console.info('Drop-in UI has been torn down!');
                                    // Remove the 'Submit payment' button
                                    $('#submit-button').remove();
                                }
                            });

                            if (result.success) {
                                window.location.href = '/success';
                            } else {
                                
                            }
                        });
                    });
                });
            });
    </script>




</form>

<div class="container w-100 d-flex justify-content-center">
    <div id="loader" class="d-none  m-5 p-5 d-flex justify-content-center">

        <div class="spinner-border text-primary d-flex justify-content-center" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <h4 class="text-center">Loading...</h4>
    </div>
</div>
@endsection