<?php

namespace Database\Seeders;

use App\Models\MatchDay;
use App\Models\User;
use App\Models\UserMatchDay;
use Illuminate\Database\Seeder;

class UserMatchDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matchDays = MatchDay::all();
        $users = User::all();

        foreach ($matchDays as $matchDay) {

            foreach ($users as $user) {

                UserMatchDay::factory()->create([
                    'match_day_id' => $matchDay->id,
                    'user_id' => $user->id,
                    'total_score' => 0,
                    'rule_points_array' => '[]'
                ]);
            }
        }
    }
}
