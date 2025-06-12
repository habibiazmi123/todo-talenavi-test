<?php

namespace Database\Factories;

use App\TodoPriority;
use App\TodoStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'assignee' => $this->faker->name,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'time_tracked' => $this->faker->numberBetween(0, 3600),
            'status' => $this->faker->randomElement(array_column(TodoStatus::cases(), 'value')),
            'priority' => $this->faker->randomElement(array_column(TodoPriority::cases(), 'value')),
        ];
    }
}
