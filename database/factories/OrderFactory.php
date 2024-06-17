<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'fio' => $faker->name(),
            'description' => $faker->text(),
            'category_id' => $faker->numberBetween(1, 3),
            'status' => 0,
            'qty' => $faker->numberBetween(100, 500),
            'pyramid_number' => $faker->numberBetween(10000, 100000)
        ];
    }
}
