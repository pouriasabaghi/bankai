<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name'=> fake()->name(),
           'desc'=>fake()->text(),
           'mobile'=>'09399127323,09125469853',
           'phone'=>'02145879532,02154889632'
        ];
    }
}
