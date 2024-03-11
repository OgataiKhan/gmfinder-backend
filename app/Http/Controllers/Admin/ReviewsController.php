<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reviews = $user->gameMaster->reviews()->paginate(5);

        return view('game_masters.reviews', compact('reviews'));
    }
}
