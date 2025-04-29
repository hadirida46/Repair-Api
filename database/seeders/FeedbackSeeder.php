<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create specialists
        $specialists = User::where('role', 'specialist')->get();

        if ($specialists->count() === 0) {
            // Create 5 specialists if none exist
            $specialists = User::factory()->count(5)->create(['role' => 'specialist']);
        }

        // Get or create users
        $users = User::where('role', 'user')->get();

        if ($users->count() === 0) {
            // Create 20 users if none exist
            $users = User::factory()->count(20)->create(['role' => 'user']);
        }

        // Create feedbacks for each specialist
        foreach ($specialists as $specialist) {
            Feedback::factory()->count(10)->create([
                'specialist_id' => $specialist->id,
                'user_id' => $users->random()->id, // Select a random user
            ]);
        }
    }
}
