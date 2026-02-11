<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'item_img' => 'storage/items/Armani+Mens+Clock.jpg',
            'item_name' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 20000),
            'detail' => $this->faker->sentence(),
            'condition' => $this->faker->numberBetween(1, 4),
            'user_id' => User::factory(),
            'sold' => '0'
        ];
    }
}
