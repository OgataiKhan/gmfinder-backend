@extends('layouts.admin')
@section('content')
<form id="payment-form" name="payment-form" action="{{ route('api.makePayment') }}" method="POST">

    @csrf

    {{-- @dd($promotionData); --}}



    <!-- includes the Braintree JS client SDK -->
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>


    <div class="pt-5">
        <p><strong>Selected promotion:</strong> <span class="tier-name">{{ $promotionData['tier'] }}</span></p>
        <p> <strong>Duration:</strong>
            @switch($promotionData['tier'])
            @case('bronze')
            <span>1 Day</span>
            @break

            @case('silver')
            <span>3 Days</span>
            @break

            @case('gold')
            <span>6 Days</span>
            @break

            @default
            <span>None</span>
            @endswitch
        </p>
        <p> <strong>Price:</strong> {{ $promotionData['price'] }} €</p>
    </div>

    <div id="dropin-wrapper">

        <div id="checkout-message"></div>
        <div id="dropin-container"></div>

        <button class="btn-void-orange" id="submit-button">Submit payment</button>

    </div>
    <script>
        var button = document.querySelector('#submit-button');
            var promotionData = {!! json_encode($promotionData) !!};
            var token = {!! json_encode($token) !!};
            let loading = false;

            var promotionDataPrice = {!! json_encode($promotionData['price']) !!}

            console.log(promotionData.price);
            console.log(promotionData.tier);
            console.log(promotionData.game_master_id);
            console.log(promotionData.end_time);

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
                        if (loading === true) {
                            $('#loader').removeClass('d-none');
                            $('#dropin-wrapper').addClass('d-none');
                        }
                        console.log('Sono arrivato alla chiamata');
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('makePayment')}}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            // contentType: 'application/json',
                            data: {
                                "amount": promotionDataPrice.toString(),
                                // "amount": "2.33",
                                "token": "fake-valid-nonce",
                                "paymentMethodNonce": payload.nonce,
                                // "paymentMethodNonce": "fake-valid-nonce",
                                // "token": token,
                                // "promotionPrice": 8.99,
                                // "promotionTier": "diamond",
                                // "promotionGameMasterId": 42,
                                // "promotionEndTime": "time-sample",
                                // "promotionPrice": promotionData.price,
                                // "promotionTier": promotionData.tier,
                                // "promotionGameMasterId": promotionData.game_master_id,
                                // "promotionEndTime": promotionData.end_time,
                            }
                        }).done(function(result) {
                            loading = false;
                            console.log('Sono arrivato a done');
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

        <div class="spinner-border d-flex justify-content-center loading" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <h4 class="text-center ms-2">Loading...</h4>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/gm-checkout.css') }}" rel="stylesheet">
@endpush