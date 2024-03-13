@extends('layouts.admin')
@section('content')
    <form id="payment-form" name="payment-form" action="{{ route('api.makePayment') }}" method="POST">

        @csrf




        <!-- includes the Braintree JS client SDK -->
        <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>


        <div id="dropin-wrapper">

            <div id="checkout-message"></div>
            <div id="dropin-container"></div>
            <button class="btn-void-orange" id="submit-button">Submit payment</button>
        </div>
        <script>
            var button = document.querySelector('#submit-button');
            var latestPromotion = {!! json_encode($latestPromotion) !!};
            var token = {!! json_encode($token) !!};

            braintree.dropin.create({
                // Insert your tokenization key here
                authorization: 'sandbox_q7nymv9j_x836p3xfjx89884d',
                container: '#dropin-container'
            }, function(createErr, instance) {
                button.addEventListener('click', function() {
                    instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                        // When the user clicks on the 'Submit payment' button this code will send the
                        // encrypted payment information in a variable called a payment method nonce
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
                            // Tear down the Drop-in UI
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
                                $('#checkout-message').html(
                                    '<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>'
                                );
                            } else {
                                console.log(result);
                                $('#checkout-message').html(
                                    '<h1>Error</h1><p>Check your console.</p>');
                            }
                        });
                    });
                });
            });
        </script>




    </form>
@endsection
