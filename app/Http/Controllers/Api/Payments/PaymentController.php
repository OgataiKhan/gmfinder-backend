<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\PaymentRequest;
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
    public function makePayment(PaymentRequest $request , Gateway $gateway){
        $result = $gateway->transaction()->sale([
            'amount'=>'10.00',
            'paymentMethodNonce'=> $request->token,
            'options'=>[
                'submitForSettlement' => true
            ]
        ]);

        if($result->success){
            $data=[
                'success'=>true,
                'message'=>'Transazione eseguita con Successo!'
            ];
        }
        else{
            $data=[
                'success'=>false,
                'message'=>'Transazione Fallita!'
            ];
        }

        return response()->json($data,401);
    }
}
