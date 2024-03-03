<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameMasterRequest;
use App\Http\Requests\UpdateGameMasterRequest;
use App\Models\GameMaster;
use App\Models\GameSystem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //give the current user
        $user = Auth::user();
        $game_masters = GameMaster::all();
        return view('game_masters.index', compact('user', 'game_masters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $game_systems = GameSystem::orderBy('name')->get();
        $provinces = config('italian_provinces');
        return view('game_masters.create', compact('game_systems'), $provinces);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameMasterRequest $request)
    {
        $data = $request->validated();


        $game_master = new GameMaster();

        // $game_master->users_id=$data['users_id'];
        // $game_master->location=$data['location'];
        // $game_master->game_description=$data['game_description'];
        // $game_master->max_players=$data['max_players'];
        // $game_master->profile_img=$data['profile_img'];
        // $game_master->is_active=$data['is_active'];
        // $game_master->is_available=$data['is_available'];
        // $game_master->slug=$data['slug'];

        $game_master->fill($data);

        $user = Auth::user();

        $game_master->slug = Str::slug($user->name);
        if (isset($data['profile_img'])) {
            $game_master->profile_img = Storage::put('uploads', $data['profile_img']);
        }
        $game_master->user_id = $user->id;

        $game_master->save();

        //To be reviewed
        if ($request->has('game_systems')) {
            $game_master->gameSystems()->sync($data['game_systems']);
        }

        return redirect()->route('game_master.index')->with('success', 'Profile successfully created');
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
        $game_master = $user->game_master;
        return view('game_masters.edit', compact('game_master'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameMasterRequest $request, User $user)
    {

        $user = Auth::user();
        $data = $request->validated();
        $game_master = $user->game_master;

        if (isset($data['profile_img'])) {
            $game_master->profile_img = Storage::put('uploads', $data['profile_img']);
            if($game_master->profile_img){
                Storage::disk('public')->delete($game_master->profile_img);                
            }
        }

        $game_master->update($data);
        $game_master->slug = Str::slug($user->name);
        $game_master->save();

        if ($request->has('game_systems')) {
            $game_master->gameSystems()->sync($data['game_systems']);
        }
        else{
            $game_master->gameSystems()->sync([]);
        }

        return redirect()->route('game_master.index')->with('success', 'Profile successfully updated');



       /*  $game_master->max_players = $data['max_players'];
        $game_master->update($data); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
