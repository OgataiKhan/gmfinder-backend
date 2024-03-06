<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\GameMaster;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request)
    {
        $data = $request->validated();
        //take the actual game master to make the connection
        $game_master = GameMaster::find($data['game_master_id']);
        $game_master->ratings()->sync($data['rating_id']);
    }
}
