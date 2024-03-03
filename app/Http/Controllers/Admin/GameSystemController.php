<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameSystem;
use Illuminate\Http\Request;

class GameSystemController extends Controller
{
    public function index()
    {
        $game_systems = GameSystem::orderBy('name')->get();
        return view('game_systems.index', ['game_systems' => $game_systems]);
    }
}
