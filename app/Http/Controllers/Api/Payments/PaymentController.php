<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\PaymentRequest;
use App\Models\Promotion;
use Braintree\Gateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function generate(Request $request, Gateway $gateway){

       $token = $gateway->clientToken()->generate();
       $data = [
        'success'=>true,
        'token'=> $token
       ];
        return response()->json($data,200);
    }


    public function index()
    {
        // Retrieve the latest promotion for display in the checkout page
        $latestPromotion = Promotion::orderBy('end_time', 'desc')->first();

        // You can customize the view name and data passed to the view as needed
        return view('game_masters.checkout', ['latestPromotion' => $latestPromotion]);
    }

    public function makePayment(PaymentRequest $request , Gateway $gateway){



        $latestPromotion = Promotion::orderBy('end_time', 'desc')->first();
        $result = $gateway->transaction()->sale([
            'amount'=>$latestPromotion->price,
            'paymentMethodNonce'=> $request->token,
            'options'=>[
                'submitForSettlement' => true
            ]
        ]);


        if ($result->success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => $result->message]);
        }
    }
}


$request = Request::create('/api/payments/make/payment', 'POST', $data); // Replace 'POST' with your method and $data with your request body
$response = Route::dispatch($request);

$result = $response->getContent(); // Get the response content