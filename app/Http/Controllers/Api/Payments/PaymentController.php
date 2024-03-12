<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\PaymentRequest;
use App\Models\Promotion;
use Braintree\Gateway;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class PaymentController extends Controller
{
    public function generate(Request $request, Gateway $gateway){

       $token = $gateway->clientToken()->generate();
       $latestPromotion = Promotion::orderBy('end_time', 'desc')->first();
       return view('game_masters.checkout', ['token' => $token,'latestPromotion' => $latestPromotion]);
    }


    

    public function makePayment(PaymentRequest $request , Gateway $gateway){

    
        
        

        $latestPromotion = Promotion::orderBy('end_time', 'desc')->first();

        $result = $gateway->transaction()->sale([
            'amount' => $latestPromotion->price,
            'paymentMethodNonce' =>  "fake-valid-nonce",
            'options' => [
            'submitForSettlement' => true
            ]
        ]);


        if ($result->success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => $result->message], 400);
            $latestPromotion->delete();
        }

       
    }
}


/* $request = Request::create('/api/payments/make/payment', 'POST', $data); // Replace 'POST' with your method and $data with your request body
$response = Route::dispatch($request);

$result = $response->getContent(); // Get the response content  */