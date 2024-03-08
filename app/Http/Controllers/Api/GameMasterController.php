<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index()
    {
        $query = GameMaster::query();

        $query->with('user', 'gameSystems', 'promotions')
            ->leftJoin('game_master_rating', 'game_masters.id', '=', 'game_master_rating.game_master_id')
            ->leftJoin('ratings', 'ratings.id', '=', 'game_master_rating.rating_id')
            ->groupBy('game_masters.id')
            ->selectRaw('game_masters.*, COALESCE(AVG(ratings.value), 0) as average_rating')
            ->selectRaw('(SELECT COUNT(*) > 0 FROM promotions WHERE promotions.game_master_id = game_masters.id AND promotions.end_time > ?) as has_future_promotion', [Carbon::now()])
            ->orderByDesc('has_future_promotion')
            ->orderBy('average_rating', 'desc');


        if (request()->key) {
            $query->whereHas('gameSystems', function ($subQuery) {
                $subQuery->where('game_systems.id', request()->key);
            })->where('is_available', true)->where('is_active', true);
        }

        $game_masters = $query->paginate(10);
        $rating = Rating::all();

        return response()->json([
            'status' => true,
            'rating' => $rating,
            'results' => $game_masters,
        ]);
    }
}


// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\GameMaster;
// use App\Models\Rating;
// use Illuminate\Http\Request;

// class GameMasterController extends Controller
// {
//     public function index()
//     {
//         $rating = Rating::all();
//         if (request()->key) {
//             $game_masters = GameMaster::whereHas('gameSystems', function ($query) {
//                 $query->where('game_systems.id', request()->key);
//             })->where('is_available', true)->where('is_active', true)->with('user', 'gameSystems', 'promotions')->paginate(10);
//         } else {
//             $game_masters = GameMaster::with('user', 'gameSystems', 'promotions')->paginate(10);
//         };

//         return response()->json([
//             'status' => true,
//             'rating' => $rating,
//             'results' => $game_masters,
//             // 'reviews_value' => $reviews,
//         ]);
//     }

//     public function show(string $slug)
//     {
//         $game_master = GameMaster::with('user', 'gameSystems', 'messages', 'reviews', 'promotions', 'ratings')->where('slug', $slug)->where('is_active', true)->first();

//         if (!$game_master) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Game master not found'
//             ]);
//         }

//         return response()->json([
//             'status' => true,
//             'result' => $game_master
//         ]);
//     }
// }
