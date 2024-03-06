<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameSystem;
use Illuminate\Http\Request;

class GameSystemController extends Controller
{
    public function index()
    {
        $game_systems=GameSystem::with('gameMasters')->orderBy('name', 'asc')->get();

        if (!$game_systems){
            return response()->json([
                'status'=>false,
                'message'=>'Game system not found'
            ]);
        }

        
        return response()->json([
            'status'=>true,
            'results' => $game_systems,
        ]);
    }


    
}
