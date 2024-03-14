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

    // Modify the queries in the countAndDistribution method to format dates

    public function countAndDistribution(Request $request)
    {
        $user = Auth::user();
        $startMonth = $request->start_month;
        $endMonth = $request->end_month;

        // Reviews and Messages aggregation adjusted to include year and format to match frontend
        $reviewsByMonth = $user->gameMaster->reviews()
            ->whereBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_year"), DB::raw('count(*) as count'))
            ->groupBy('month_year')
            ->get()
            ->pluck('count', 'month_year');

        $messagesByMonth = $user->gameMaster->messages()
            ->whereBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_year"), DB::raw('count(*) as count'))
            ->groupBy('month_year')
            ->get()
            ->pluck('count', 'month_year');

        // Distribution of ratings (no change needed here)
        $ratingsDistribution = $user->gameMaster->ratings()
            ->wherePivotBetween('created_at', ["{$startMonth}-01", "{$endMonth}-31"])
            ->get()
            ->groupBy('value')
            ->map(function ($items, $value) {
                return count($items);
            });

        return response()->json([
            'reviewsByMonth' => $reviewsByMonth,
            'messagesByMonth' => $messagesByMonth,
            'ratingsDistribution' => $ratingsDistribution,
        ]);
    }
}
