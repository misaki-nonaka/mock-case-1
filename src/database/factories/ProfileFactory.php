<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'nickname' => $this->faker->name(),
            'profile_img' => 'storage/profiles/sample01.jpg',
            'zipcode' => $this->faker->postcode,
            'address' => $this->faker->streetAddress(),
            'building' => $this->faker->word(),
        ];
    }
}
