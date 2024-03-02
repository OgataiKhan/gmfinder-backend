<?php

namespace Database\Seeders;

use App\Models\GameSystem;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game_systems = config('game_systems');

        foreach ($game_systems as $gameSystemData) {
            $slug = Str::slug($gameSystemData['name']);

            $newGameSystem = new GameSystem();
            $newGameSystem->name = $gameSystemData['name'];
            $newGameSystem->description = $gameSystemData['description'];
            $newGameSystem->slug = $slug;
            $newGameSystem->save();
        }
    }
}
