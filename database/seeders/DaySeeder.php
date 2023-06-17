<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Day::factory()->create([
            'day_number' => 1,
            'as_word' => 'one',
            'days_since_match_start' => 0
        ]);

        Day::factory()->create([
            'day_number' => 2,
            'as_word' => 'two',
            'days_since_match_start' => 1
        ]);

        Day::factory()->create([
            'day_number' => 3,
            'as_word' => 'three',
            'days_since_match_start' => 2
        ]);

        Day::factory()->create([
            'day_number' => 4,
            'as_word' => 'four',
            'days_since_match_start' => 3
        ]);

        Day::factory()->create([
            'day_number' => 5,
            'as_word' => 'five',
            'days_since_match_start' => 4
        ]);
    }
}
