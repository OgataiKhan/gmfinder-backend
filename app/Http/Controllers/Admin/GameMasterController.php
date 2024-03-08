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
        $game_master->fill($data);

        $user = Auth::user();

        $game_master->slug = Str::slug($user->name) . Str::random(10);
        if (isset($data['profile_img'])) {
            $game_master->profile_img = Storage::put('uploads', $data['profile_img']);
        }
        $game_master->user_id = $user->id;

        $game_master->save();

        if (isset($data['game_systems'])) {
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
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->gameMaster->id != $id) {
            return redirect()->route('game_master.edit', ['game_master' => $user->gameMaster->id])
                ->with('error', 'You are not authorized to edit this information.');
        }

        $game_master = $user->gameMaster;
        $game_systems = GameSystem::orderBy('name')->get();
        $provinces = config('italian_provinces');

        return view('game_masters.edit', compact('game_master', 'game_systems'), $provinces);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameMasterRequest $request, User $user)
    {

        $user = Auth::user();
        $data = $request->validated();
        $game_master = $user->gameMaster;
        $game_master->update($data);

        if ($request->hasFile('profile_img')) {
            if (isset($game_master->profile_img)) {
                Storage::disk('public')->delete($game_master->profile_img);
            }
            $game_master->profile_img = $request->file('profile_img')->store('uploads', 'public');
        }

        // $game_master->slug = Str::slug($user->name);
        $game_master->save();

        if ($request->has('game_systems')) {
            $game_master->gameSystems()->sync($data['game_systems']);
        } else {
            $game_master->gameSystems()->sync([]);
        }

        return redirect()->route('game_master.index')->with('success', 'Profile successfully updated');



        /*  $game_master->max_players = $data['max_players'];
        $game_master->update($data); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = Auth::user();

        $gameMaster = $user->gameMaster;

        if ($gameMaster->profile_img) {
            Storage::delete($gameMaster->profile_img);
            $gameMaster->profile_img = null;
            $gameMaster->save();
        }

        if ($gameMaster) {
            $gameMaster->is_active = 0;
            $gameMaster->save();
        }

        $timestamp = now()->format('YmdHis'); // Get current timestamp
        $user->email = "{$user->email}_deleted_{$timestamp}"; // Append a "deleted" string and the current timestamp to email
        $user->save();

        // Soft-delete associated user
        $user->delete();

        // Log user out after soft-deleting
        Auth::logout();

        // return redirect()->route('game_master.index')->with('delete', 'Profile deleted successfully');
        return redirect()->route(env('FRONTEND_URL'))->with('status', 'Profile deleted successfully');
    }
}
