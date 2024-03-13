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
        // Take the actual game master to make the connection
        $game_master = GameMaster::find($data['game_master_id']);

        // Prepare timestamps
        $additionalData = ['created_at' => now(), 'updated_at' => now()];

        // Attach rating with timestamps
        $game_master->ratings()->attach($data['rating_id'], $additionalData);
    }
}

/*
data taken from form trough v-model

formData={
    rating: null; // selected rating id
}

axios call

function sendRating(){
    data={
        rating_id: formData.rating,
        game_master_id : game_master.id
    }

    axios.post('/ratings', data).then(response=>{
        return success message
    }).catch(error=>{
        return error message
    })
}

*/