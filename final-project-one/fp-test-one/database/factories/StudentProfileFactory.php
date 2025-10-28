<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<StudentProfile> */
class StudentProfileFactory extends Factory
{
    protected $model = StudentProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'skills' => ['php','laravel','vue'],
            'bio' => $this->faker->paragraph(),
            'education' => [['school' => $this->faker->company(), 'degree' => 'BSc', 'year' => 2023]],
            'portfolio_url' => $this->faker->optional()->url(),
        ];
    }
}
