<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Cow;
use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;

class CowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "breed_id" => function () {
                return Breed::inRandomOrder()->first()->id;
            },
            "farm_id" => function () {
                return Farm::inRandomOrder()->first()->id;
            },
            "name" => $this->faker->name,
            "weight" => $this->faker->randomDigit(),
            "type" => $this->faker->randomElement(["dairy", "fattening"]),
            "gender" => $this->faker->randomElement(["male", "female"]),
            "description" => $this->faker->paragraph,
            "dob" => $this->faker->dateTimeBetween(startDate: "-5years"),
        ];
    }
}
