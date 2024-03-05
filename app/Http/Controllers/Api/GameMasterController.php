<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index()
    {
        $game_masters=GameMaster::with('gameSystems','messages','reviews','promotions','ratings')->paginate(9);

        // Verifying if game master exists
        if (!$game_masters) {
            return response()->json([
                'status'=>false,
                'message'=>'Game master not found'
            ]);
        }
        
        return response()->json([
            'status'=>true,
            'results' => $game_masters,
        ]);
    }


    
    public function show(string $id){
        $game_master = GameMaster::with('gameSystems')->where('user_id', $id)->first();

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
