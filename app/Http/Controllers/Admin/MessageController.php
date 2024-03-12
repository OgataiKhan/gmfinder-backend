<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = $user->gameMaster->messages()->orderBy('created_at', 'desc')->paginate(5);
        return view('game_masters.messages', compact('messages'));
    }
}
