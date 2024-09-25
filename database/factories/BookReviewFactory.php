<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Author>
 */
class BookReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'review' => $faker->randomElement(range(1, 10)),
            'comment' => $faker->text(),
        ];
    }
}
