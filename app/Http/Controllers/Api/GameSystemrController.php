<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameSystem;
use Illuminate\Http\Request;

class GameSystemrController extends Controller
{
    public function index()
    {
        $game_systems=GameSystem::with('gameMasters')->paginate(9);

        
        return response()->json([
            'status'=>true,
            'results' => $game_systems,
        ]);
    }


    
}
