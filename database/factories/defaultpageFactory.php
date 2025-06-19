<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class defaultpageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $factory->define(Page::class, function (Faker $faker) {
            return [
                'title' => 'home',
                'post' => 'home',
                'metatext' => 'home',

            ];
        });
        
    }
}
