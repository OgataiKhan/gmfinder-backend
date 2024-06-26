<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use App\Models\Promotion;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index(Request $request)
    {
        $query = GameMaster::with('user', 'gameSystems', 'promotions')
            ->select('game_masters.*')
            ->selectSub(function ($query) {
                $query->from('game_master_rating')
                    ->selectRaw('COALESCE(AVG(ratings.value), 0)')
                    ->join('ratings', 'ratings.id', '=', 'game_master_rating.rating_id')
                    ->whereColumn('game_master_rating.game_master_id', 'game_masters.id');
            }, 'average_rating')
            ->selectSub(function ($query) {
                $query->from('reviews')
                    ->selectRaw('COUNT(DISTINCT reviews.id)')
                    ->whereColumn('reviews.game_master_id', 'game_masters.id');
            }, 'reviews_count')
            ->selectSub(function ($query) {
                $query->from('game_master_rating')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('game_master_rating.game_master_id', 'game_masters.id');
            }, 'ratings_count')
            ->selectSub(function ($query) {
                $query->from('promotions')
                    ->selectRaw('COUNT(*)')
                    ->where('promotions.end_time', '>', Carbon::now())
                    ->whereColumn('promotions.game_master_id', 'game_masters.id');
            }, 'has_future_promotion')
            ->orderByDesc('has_future_promotion')
            ->orderBy('average_rating', 'desc');

        // Filter by Game System
        if ($request->has('key')) {
            $query->whereHas('gameSystems', function ($subQuery) use ($request) {
                $subQuery->where('game_systems.id', $request->key);
            })->where('is_active', true)->where('is_available', true);
        }

        // Filter by minimum average rating
        if ($request->has('min_average_rating')) {
            $query->having('average_rating', '>=', (float) $request->min_average_rating);
        }

        // Filter by minimum number of reviews
        if ($request->has('min_reviews')) {
            $query->having('reviews_count', '>=', (int) $request->min_reviews);
        }

        $game_masters = $query->paginate(10);

        return response()->json([
            'status' => true,
            'results' => $game_masters,
        ]);
    }



    public function show(Request $request, string $slug)
    {
        $game_master = GameMaster::with(['user', 'gameSystems', 'promotions', 'reviews'])
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
        $perPage = $request->get('per_page', 5); // Default to 5 items per page if not specified
        $reviews = $game_master->reviews()->orderBy('created_at', 'desc')->paginate($perPage);

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
            ->orderByDesc(
                Promotion::select('created_at')
                    ->whereColumn('promotions.game_master_id', 'game_masters.id')
                    ->where('end_time', '>', Carbon::now())
                    ->orderBy('end_time', 'desc')
                    ->limit(1)
            )
            ->paginate(4);

        return response()->json([
            'status' => true,
            'results' => $featured_game_masters,
        ]);
    }
}