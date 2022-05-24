<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Subscription;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $country = Country::all()->random(1)->first();
        $subscription = Subscription::all()->random(1)->first();

        return [
            'name'      => ['ar' => $arFaker->company, 'en' => $this->faker->company],
            'image'     => $this->faker->imageUrl(400, 400, null, false, 'Vendor'),
            'is_active' => $this->faker->boolean,
            'subscription_id'       => new ObjectId($subscription->_id),
            'darbi_percentage'      => $this->faker->randomFloat(1, 1, 100),
            'country_id'            => new ObjectId($country->_id),
            'require_activation'    => $this->faker->boolean
        ];
    }
}

