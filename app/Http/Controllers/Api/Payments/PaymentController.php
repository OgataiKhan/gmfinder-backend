<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\PaymentRequest;
use App\Http\Requests\StorePromotionRequest;
use App\Models\Promotion;
use Braintree\Gateway;
use Carbon\Carbon;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function generate(Request $request, Gateway $gateway){

       $token = $gateway->clientToken()->generate();
       $latestPromotion = Promotion::orderBy('end_time', 'desc')->first();
       return view('game_masters.checkout', ['token' => $token,'latestPromotion' => $latestPromotion]);
    }

    public function makePayment(PaymentRequest $request , Gateway $gateway){

        $latestPromotion = Promotion::
        orderBy('id', 'desc')->first();

        

      
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
                $latestPromotion->delete();
                return response()->json(['success' => false, 'message' => $result->message], 400);
                
            }
       
    }

    public function success(Request $request){
        return view('game_masters.success');
    }

   
}

