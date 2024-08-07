@extends('layouts.admin')
@section('content')
	<form id="payment-form" name="payment-form" action="{{ route('api.makePayment') }}" method="POST">

		@csrf

		{{-- @dd($promotionData); --}}



		<!-- includes the Braintree JS client SDK -->
		<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


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

			if (token) {
				braintree.dropin.create({
					// Insert your tokenization key here
					authorization: 'sandbox_q7nymv9j_x836p3xfjx89884d',
					container: '#dropin-container'
				}, function(createErr, instance) {
					if (createErr) {
						console.error('Error creating Drop-in UI:', createErr);
						return;
					}

					const button = document.getElementById('submit-button');
					button.addEventListener('click', function() {
						event.preventDefault();
						instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
							if (requestPaymentMethodErr) {
								console.error('Error requesting payment method:', requestPaymentMethodErr);
								return;
							}

							// Show loading spinner
							$('#loader').removeClass('d-none');
							$('#dropin-wrapper').addClass('d-none');

							axios.post('{{ route('makePayment') }}', {
									amount: promotionDataPrice.toString(),
									token: "fake-valid-nonce",
									paymentMethodNonce: payload.nonce
								}, {
									headers: {
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
										'Content-Type': 'application/json',
									}
								})
								.then(function(response) {
									$('#loader').addClass('d-none');
									$('#dropin-wrapper').removeClass('d-none');


									// Teardown Drop-in UI
									instance.teardown(function(teardownErr) {
										if (teardownErr) {
											console.error('Could not tear down Drop-in UI:',
												teardownErr);
										} else {
											console.info('Drop-in UI has been torn down!');
											// Remove the 'Submit payment' button
											$('#submit-button').remove();
										}
									});

									if (response.data.success) {
										window.location.href = '/success';
									} else {
										console.log('Payment failed:', response.data.message);
									}
								})
								.catch(function(error) {
									console.error('Payment error:', error);
								});
						});
					});
				});
			}
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
