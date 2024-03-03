<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\GameMaster;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = config('users');

        foreach ($users as $userData) {
            // Create user
            $newUser = new User();
            $newUser->name = $userData['name'];
            $newUser->email = $userData['email'];
            $newUser->password = bcrypt($userData['password']);
            $newUser->role = $userData['role'];
            $newUser->save();

            // Create game master depending on role
            if ($userData['role'] === 'game_master') {
                $slug = Str::slug($userData['name']) . Str::random(10);

                $newGameMaster = new GameMaster();
                $newGameMaster->user_id = $newUser->id;
                $newGameMaster->slug = $slug;
                $newGameMaster->location = $userData['location'];
                $newGameMaster->game_description = $userData['game_description'];
                $newGameMaster->max_players = $userData['max_players'];
                $newGameMaster->save();
            }
        }
    }
}
