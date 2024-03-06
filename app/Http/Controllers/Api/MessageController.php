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


/*  
data taken from form trough v-model

cost formData = {
    text: null,
    name: null,
    email: null,
}

axios call

function postMessage(){
    const data = {
        game_master_id : game_master.id,
        text : fromData.text,
        name : formData.name,
        email : formData.email
    }

    axios.post('route/messages', data).then=>(response=>{
        return a success message
    }).catch(error=>{
        return a error message
    })
}
*/