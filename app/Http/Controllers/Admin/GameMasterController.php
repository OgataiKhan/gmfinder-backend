<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGameMasterRequest;
use App\Models\GameMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //give the current user
        $user = Auth::user();
        return view('game_masters.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        $game_master = $user->gameMaster;
        return view('game_masters.edit', compact('game_master'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameMasterRequest $request, User $user)
    {

        $user = Auth::user();
        $data = $request->validated();

        $gameMaster = $user->gameMaster;
        $gameMaster->max_players = $data['max_players'];
        $gameMaster->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
