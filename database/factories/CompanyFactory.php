<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company(),
            'inn' => $this->faker->inn(),
            'description' => $this->faker->realText(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'director' => $this->faker->name(),
        ];
    }
}
