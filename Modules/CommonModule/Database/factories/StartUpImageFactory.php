<?php

namespace Modules\CommonModule\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StartUpImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CommonModule\Entities\StartUpImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-1 years', '+1 month')->getTimestamp());

        return [
            'image'      => $this->faker->imageUrl(400, 700, null, false, 'Startup Image'),
            'is_active'  => $this->faker->boolean,
            'valid_from' => $startDate->toDateTimeString(),
            'valid_to'   => $startDate->addMonths($this->faker->numberBetween(1,10))->toDateTimeString()
        ];
    }
}

