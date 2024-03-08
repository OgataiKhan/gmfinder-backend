<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index()
    {
        if (request()->key) {
            $game_masters = GameMaster::whereHas('gameSystems', function ($query) {
                $query->where('game_systems.id', request()->key);
            })->where('is_available', true)->where('is_active', true)->with('user', 'gameSystems', 'promotions')->paginate(10);
        } else {
            $game_masters = GameMaster::with('user', 'gameSystems','promotions')->paginate(10);
        };

        // Not necessary because paginate() will always return a paginator instance, so you'll never enter this case
        // Verifying if game master exists
        // if (!$game_masters) {
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'Game master not found'
        //     ]);
        // }

        return response()->json([
            'status' => true,
            'results' => $game_masters,
        ]);
    }

    public function show(string $slug)
    {
        $game_master = GameMaster::with('user', 'gameSystems', 'messages', 'reviews', 'promotions', 'ratings')->where('slug', $slug)->where('is_active', true)->first();

        if (!$game_master) {
            return response()->json([
                'status' => false,
                'message' => 'Game master not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'result' => $game_master
        ]);
    }
}
