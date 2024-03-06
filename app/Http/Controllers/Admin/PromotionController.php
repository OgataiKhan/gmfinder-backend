<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromotionRequest;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function addPromotion(StorePromotionRequest $request)
    {
        $data = $request->validated();

        $promotion = new Promotion();
        $promotion->game_master_id = $data['game_master_id'];
        $promotion->tier = $data['tier'];

        // Adjust end_time calculation based on the tier
        switch ($data['tier']) {
            case 'bronze':
                $hoursToAdd = 24;
                break;
            case 'silver':
                $hoursToAdd = 72;
                break;
            case 'gold':
                $hoursToAdd = 144;
                break;
            default:
                $hoursToAdd = 0; // Default case, should never be used due to the validation
        }

        $promotion->end_time = Carbon::now()->addHours($hoursToAdd);
        $promotion->save();

        return response()->json([
            'message' => 'Promotion added successfully',
            'promotion' => $promotion,
        ]);
    }
}
