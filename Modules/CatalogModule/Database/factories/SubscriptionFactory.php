<?php

namespace Modules\CatalogModule\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AuthModule\Entities\Admin;
use MongoDB\BSON\ObjectId;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::all()->random(1)->first();
        $startDate = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-1 years', '+1 month')->getTimestamp());

        return [
            'start_at'  => $startDate->toDateTimeString(),
            'end_at'    => $startDate->addMonths($this->faker->numberBetween(1,10))->toDateTimeString(),
            'created_by'=> [
                'id'        => new ObjectId($admin->_id),
                'on_model'  => Admin::class
            ]
        ];
    }
}

