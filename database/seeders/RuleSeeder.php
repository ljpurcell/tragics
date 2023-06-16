<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rule::factory()->create([
            'name' => 'century',
            'description' => '100 runs attributed to the batsman',
            'points' => 10
        ]);

        Rule::factory()->create([
            'name' => 'half-century',
            'description' => '50 runs attributed to the batsman',
            'points' => 5
        ]);


        Rule::factory()->create([
            'name' => 'run out',
            'description' => 'the fieldsman awarded the run out on the scorecard',
            'points' => 3
        ]);


        Rule::factory()->create([
            'name' => 'wicket',
            'description' => 'dimissing a batsman in any legal fashion',
            'points' => 2
        ]);

        Rule::factory()->create([
            'name' => 'successful review',
            'description' => 'awarded to the bowler for a decision initially given not-out but successfully overturned by DRS',
            'points' => 1
        ]);

        Rule::factory()->create([
            'name' => 'catch',
            'description' => 'the fieldsman awarded the catch on the scorecard',
            'points' => 1
        ]);

        Rule::factory()->create([
            'name' => 'dropped catch',
            'description' => 'a dropped catch, must be be voted as a chance by all three opponents of the offender',
            'points' => -1
        ]);

        Rule::factory()->create([
            'name' => 'winning wicket',
            'description' => 'a dismissal that wins the match, points are in addition to the regular wicket',
            'points' => 5
        ]);

        Rule::factory()->create([
            'name' => 'winning runs',
            'description' => 'runs that are attributed to the batsman that win the match, additional to any milestone points',
            'points' => 5
        ]);
    }
}
