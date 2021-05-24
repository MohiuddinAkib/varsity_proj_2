<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "payment_status" => $this->faker->randomElement(["paid", "unpaid"]),
            "payment_date" => function ($attributes) {
                if ($attributes["payment_status"] === "paid") {
                    return $this->faker->dateTimeThisMonth();
                }

                return null;
            },
            "payment_cut" => $this->faker->numberBetween(0, 2000),
            "payment_bonus" => $this->faker->numberBetween(0, 2000),
            "payment_bonus_reason" => function ($attributes) {
                if ($attributes["payment_bonus"] > 0) {
                    return $this->faker->sentence();
                }

                return null;
            },
            "payment_cut_reason" => function ($attributes) {
                if ($attributes["payment_cut"] > 0) {
                    return $this->faker->sentence();
                }

                return null;
            },
        ];
    }
}
