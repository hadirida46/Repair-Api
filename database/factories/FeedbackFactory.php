<?php
namespace Database\Factories;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'specialist_id' => User::factory(), 
            'user_id' => User::factory(),       
            'review' => $this->faker->sentence(),
        ];
    }
}

