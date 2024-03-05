<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index()
    {
        $game_masters=GameMaster::with('gameSystems')->paginate(9);

        
        return response()->json([
            'status'=>true,
            'results' => $game_masters,
        ]);
    }
}
