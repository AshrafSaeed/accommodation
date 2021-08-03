<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Greate hotel '.$this->faker->name(),
            'rating' => 5,
            'category' => 'hotel',
            'image_url' => 'http:example.com/folder/image.png',
            'reputation' =>4543,
            'reputation_badge' => 'red',
            'price' => 5000,
            'availability' => 10
        ];
    }
}
    
