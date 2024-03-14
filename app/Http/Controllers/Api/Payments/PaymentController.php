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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function generate(Request $request, Gateway $gateway)
    {
        $token = $gateway->clientToken()->generate();

        // Check if promotion data is available in the session
        if (!Session::has('promotionData')) {
            
        }

        // Retrieve promotion data from session
        $promotionData = Session::get('promotionData');
        
        return view('game_masters.checkout', ['token' => $token, 'promotionData' => $promotionData]);
    }


    public function makePayment(PaymentRequest $request, Gateway $gateway)
    {
        

        $result = $gateway->transaction()->sale([
            'amount' => $request->input('amount'),
            'paymentMethodNonce' =>  $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);


        if ($result->success) {
            $user = Auth::user();
            $gameMasterId = $user->gameMaster->id;

            $latestPromotion = Promotion::where('game_master_id', $gameMasterId)
                ->orderBy('end_time', 'desc')
                ->first();

            $currentTime = Carbon::now();
            $baseTime = $currentTime;

            // If there's an active promotion and it ends in the future, set baseTime to its end_time
            if ($latestPromotion && $latestPromotion->end_time->isFuture()) {
                $baseTime = $latestPromotion->end_time;
            }

            switch ($result->transaction->amount) {
                case 2.99:
                    $tier = 'bronze';
                    $hoursToAdd = 24; // 1 day
                    break;
                case 5.99:
                    $tier = 'silver';
                    $hoursToAdd = 72; // 3 days
                    break;
                case 9.99:
                    $tier = 'gold';
                    $hoursToAdd = 144; // 6 days
                    break;
                default:
                    $tier = 'failed';
                    $hoursToAdd = 0; // Default case
            }

            $endTime = $baseTime->addHours($hoursToAdd);

            $promotion = new Promotion();
            $promotion->game_master_id = $gameMasterId;
            $promotion->tier = $tier;
            $promotion->price = $result->transaction->amount;
            $promotion->end_time = $endTime;
            $promotion->save();

            return response()->json(['success' => true]);
        } else {

            return response()->json(['success' => false, 'message' => $result->message], 400);
        }
    }

    public function success(Request $request)
    {
        return view('game_masters.success');
    }
}
