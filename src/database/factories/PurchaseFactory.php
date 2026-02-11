<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\User;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'payment' => 'konbini',
            'item_zipcode' => $this->faker->postcode,
            'item_address' => $this->faker->streetAddress(),
            'item_building' => $this->faker->word(),
            'status' => 'paid',
        ];
    }
}
