<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(20)
                    ->create(['role' => 'teacher'])
                    ->each(function ($user) {
                        Teacher::create(['user_id' => $user->id]);
                    });

    }
}
