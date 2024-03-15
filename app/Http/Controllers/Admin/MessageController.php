<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = $user->gameMaster->messages()->orderBy('created_at', 'desc')->paginate(5);
        //format date
        foreach ($messages as $message) {
            $message->createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at, 'UTC')
                ->setTimezone('Europe/Rome')
                ->format('d/m/Y H:i');
        }
        return view('game_masters.messages', compact('messages'));
    }
}
