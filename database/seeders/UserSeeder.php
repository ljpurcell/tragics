<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Lyndon',
            'email' => 'lyndonpurcell23@gmail.com',
            'password' => Hash::make('lyndonpurcell23@gmail.com')
        ]);

        User::factory()->create([
            'name' => 'Ben W',
            'email' => 'bjwoollard94@gmail.com',
            'password' => Hash::make('bjwoollard94@gmail.com')
        ]);
    }
}
