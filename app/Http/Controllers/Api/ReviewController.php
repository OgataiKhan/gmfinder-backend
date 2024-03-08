<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $message = new Review();

        $message->game_master_id = $data['game_master_id'];
        $message->text = $data['text'];
        $message->name = $data['name'];
        $message->email = $data['email'];
        $message->save();
    }
}
