<?php

namespace Database\Factories;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Farm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "city" => $this->faker->city,
            "name" => $this->faker->company,
            "region" => $this->faker->state,
            "area" => $this->faker->areaCode,
            "address" => $this->faker->address,
            "closed_at" => $this->faker->dateTimeBetween($startDate = '-2years', $endDate = 'now', $timezone = null),
            "established_at" => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = '-2years', $timezone = null),
        ];
    }
}
