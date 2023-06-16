<?php

namespace Database\Seeders;

use App\Models\TestMatch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TestMatch::factory()->create([
            'match_number' => 1,
            'match_number_as_word' => 'one',
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-06-16')
        ]);

        TestMatch::factory()->create([
            'match_number' => 2,
            'match_number_as_word' => 'two',
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-06-28')
        ]);

        TestMatch::factory()->create([
            'match_number' => 3,
            'match_number_as_word' => 'three',
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-07-06')
        ]);

        TestMatch::factory()->create([
            'match_number' => 4,
            'match_number_as_word' => 'four',
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-07-19')
        ]);

        TestMatch::factory()->create([
            'match_number' => 5,
            'match_number_as_word' => 'five',
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-07-27')
        ]);
    }
}
