<?php

namespace Database\Seeders;

use App\Models\Day;
use App\Models\MatchDay;
use App\Models\TestMatch;
use Illuminate\Database\Seeder;

class MatchDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matches = TestMatch::all();
        $days = Day::all();

        foreach ($matches as $match) {
            foreach ($days as $day) {
                MatchDay::factory()->create([
                    'match_number' => $match->match_number,
                    'day_number' => $day->day_number
                ]);
            }
        }
    }
}
