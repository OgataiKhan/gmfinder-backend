<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        $data = $request->validated();
        $message = new Message();

        $message->game_master_id = $data['game_master_id'];
        $message->text = $data['text'];
        $message->name = $data['name'];
        $message->email = $data['email'];
        $message->save();
    }
}
