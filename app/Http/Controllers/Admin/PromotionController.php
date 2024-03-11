<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{

    public function create()
    {
        $promotionTiers = config('promotion_tiers');

        $user = Auth::user();
        // $gameMasterId = optional($user->gameMaster)->id;
        $gameMasterId = $user->gameMaster->id;
        if (!$gameMasterId) {
            // Handle no associated game master record case
            return redirect()->route('game_master.create')->with('error', 'You must be a Game Master to access this.');
        }

        return view('game_masters.promotions', compact('promotionTiers', 'gameMasterId'));
    }


    public function store(StorePromotionRequest $request)
    {
        $data = $request->validated();

        // Find the latest promotion for this game master
        $latestPromotion = Promotion::where('game_master_id', $data['game_master_id'])
                                ->orderBy('end_time', 'desc')
                                ->first();

        $currentTime = Carbon::now();
        $baseTime = $currentTime;

        // If there's an active promotion and it ends in the future, set baseTime to its end_time
        if ($latestPromotion && $latestPromotion->end_time->isFuture()) {
            $baseTime = $latestPromotion->end_time;
        }

        // $promotionTiers = config('promotion_tiers');

        // Adjust end_time calculation based on the tier
        switch ($data['tier']) {
            case 'bronze':
                $hoursToAdd = 24; // 1 day
                $price = 2.99;
                break;
            case 'silver':
                $hoursToAdd = 72; // 3 days
                $price = 5.99;
                break;
            case 'gold':
                $hoursToAdd = 144; // 6 days
                $price = 9.99;
                break;
            default:
                $hoursToAdd = 0; // Default case, should never be used due to the validation
        }

        // Calculate new end_time from the baseTime
        $promotion = new Promotion();
        $promotion->game_master_id = $data['game_master_id'];
        $promotion->tier = $data['tier'];
        $promotion->price = $price;
        $promotion->end_time = $baseTime->addHours($hoursToAdd);
        $promotion->save();

        // return response()->json([
        //     'message' => 'Promotion added successfully',
        //     'promotion' => $promotion,
        // ]);
        return redirect()->route('game_masters.checkout')->with('success', 'Promotion successfully purchased', compact('promotion'));
}
