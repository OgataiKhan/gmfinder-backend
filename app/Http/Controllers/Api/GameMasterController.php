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
            ->selectRaw('COUNT(ratings.id) as ratings_count')
            ->selectRaw('(SELECT COUNT(*) FROM promotions WHERE promotions.game_master_id = game_masters.id AND promotions.end_time > ?) as has_future_promotion', [Carbon::now()])
            ->orderByDesc('has_future_promotion')
            ->orderBy('average_rating', 'desc');

        if (request()->key) {
            $query->whereHas('gameSystems', function ($subQuery) {
                $subQuery->where('game_systems.id', request()->key);
            })->where('is_active', true)->where('is_available', true);
        }

        $game_masters = $query->paginate(10);

        return response()->json([
            'status' => true,
            'results' => $game_masters,
        ]);
    }


    public function show(Request $request, string $slug)
    {
        $game_master = GameMaster::with(['user', 'gameSystems', 'promotions'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$game_master) {
            return response()->json([
                'status' => false,
                'message' => 'Game master not found'
            ]);
        }

        // Check for future promotions
        $has_future_promotion = $game_master->promotions()->where('end_time', '>', Carbon::now())->exists();

        // Calculate the average rating
        $average_rating = $game_master->ratings()->avg('value') ?? 0;

        // Calculate the number of ratings
        $ratings_count = $game_master->ratings()->count();

        // Add calculated values to the GameMaster object
        $game_master->has_future_promotion = $has_future_promotion;
        $game_master->average_rating = $average_rating;
        $game_master->ratings_count = $ratings_count;

        // Paginate reviews
        $perPage = $request->get('per_page', 10); // Default to 10 items per page if not specified
        $reviews = $game_master->reviews()->paginate($perPage);

        return response()->json([
            'status' => true,
            'result' => $game_master,
            'reviews' => $reviews
        ]);
    }

    public function featuredGameMasters()
    {
        $featured_game_masters = GameMaster::query()
            ->with('user', 'gameSystems', 'promotions')
            ->whereHas('promotions', function ($query) {
                $query->where('end_time', '>', Carbon::now());
            })
            ->where('is_active', true)
            ->where('is_available', true)
            ->select('game_masters.*')
            ->leftJoin('game_master_rating', 'game_masters.id', '=', 'game_master_rating.game_master_id')
            ->leftJoin('ratings', 'ratings.id', '=', 'game_master_rating.rating_id')
            ->groupBy('game_masters.id')
            ->selectRaw('COALESCE(AVG(ratings.value), 0) as average_rating')
            ->orderBy('average_rating', 'desc')
            ->paginate(4);

        return response()->json([
            'status' => true,
            'results' => $featured_game_masters,
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
