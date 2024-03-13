<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function show()
    {
        return view('game_masters.stats');
    }

    public function countAndDistribution(Request $request)
    {
        $user = Auth::user();
        $startMonth = $request->start_month;
        $endMonth = $request->end_month;

        // Count reviews
        $reviewsCount = $user->gameMaster->reviews()
            ->whereBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->count();

        // Count messages
        $messagesCount = $user->gameMaster->messages()
            ->whereBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->count();

        // Distribution of ratings
        $ratingsDistribution = $user->gameMaster->ratings()
            ->wherePivotBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->get()
            ->groupBy('value')
            ->map(function ($items, $value) {
                return count($items);
            });

        return response()->json([
            'reviewsCount' => $reviewsCount,
            'messagesCount' => $messagesCount,
            'ratingsDistribution' => $ratingsDistribution,
        ]);
    }
}
