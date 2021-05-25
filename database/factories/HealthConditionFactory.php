<?php

namespace Database\Factories;

use App\Models\Cow;
use App\Models\HealthCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class HealthConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HealthCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "cow_id" => function () {
                return Cow::inRandomOrder()->first()->id;
            },
            "condition" => $this->faker->randomElement(["good", "bad"]),
            "note" => $this->faker->optional()->paragraph,
        ];
    }
}
