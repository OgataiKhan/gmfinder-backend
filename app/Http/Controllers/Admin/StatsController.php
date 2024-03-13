<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $gameMaster = $user->gameMaster;

    // Fetch ratings
    $ratings = $gameMaster->ratings()->get()->pluck('value');

    // Fetch messages
    $messages = $gameMaster->messages()->get();
    
    // Fetch reviews
    $reviews = $gameMaster->reviews()->get();

    return view('game_masters.stats', compact('reviews', 'messages', 'ratings'));
}

}
