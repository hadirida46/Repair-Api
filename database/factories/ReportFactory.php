<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    public function definition()
{
    return [
        'user_id' => User::factory(), 
        'specialist_id' => null,
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'status' => 'pending',
        'images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
}
