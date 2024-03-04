<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratings = config('ratings');

        foreach ($ratings as $ratingData) {

            $newRating = new Rating();
            $newRating->value = $ratingData['value'];
            $newRating->save();
        }
    }
}
