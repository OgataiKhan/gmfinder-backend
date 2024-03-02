<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GameSystem;

class GameMasterGameSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = config('game_master_assignments.assignments');

        foreach ($assignments as $userName => $systemNames) {
            // Find the user whose name matches the data entry
            $user = User::where('name', $userName)->first();
            if (!$user) {
                continue;
            }

            // Access the game master profile corresponding to that user
            $gameMaster = $user->gameMaster;
            if (!$gameMaster) {
                continue;
            }

            // Find the matching game systems and attach them to the accessed game master
            $systemIds = GameSystem::whereIn('name', $systemNames)->pluck('id');
            $gameMaster->gameSystems()->attach($systemIds);
        }
    }
}
