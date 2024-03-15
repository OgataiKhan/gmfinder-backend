<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reviews = $user->gameMaster->reviews()->orderBy('created_at', 'desc')->paginate(5);
        //format date
        foreach ($reviews as $review) {
            $review->createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at, 'UTC')
                ->setTimezone('Europe/Rome')
                ->format('d/m/Y H:i');
        }
        return view('game_masters.reviews', compact('reviews'));
    }
}
