<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use Illuminate\Http\Request;

class GameMasterController extends Controller
{
    public function index()
    {
        if (request()->key)
        {
            $game_masters = GameMaster::whereHas('gameSystems', function ($query) {
                $query->where('name', 'LIKE', '%' . request()->key . '%');
            })->paginate(10);
        } else
         {
            $game_masters=GameMaster::with('gameSystems','messages','reviews','promotions','ratings')->paginate(10);
        };

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


    
    public function show(string $slug){
        $game_master = GameMaster::with('gameSystems')->where('slug', $slug)->first();

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
