<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
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
            "name" => $this->faker->company,
            "location" => $this->faker->address,
            "latitude" => $this->faker->latitude(),
            "longitude" => $this->faker->longitude(),
            "contact_number" => $this->faker->phoneNumber,
            "establish_date" => $this->faker->dateTimeBetween(),
        ];
    }
}
