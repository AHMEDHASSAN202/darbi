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
//        $subscription = Subscription::all();

        return [
            'name'                  => ['ar' => $arFaker->company, 'en' => $this->faker->company],
            'image'                 => $this->faker->imageUrl(400, 400, null, false, 'Vendor'),
            'is_active'             => true, //$this->faker->boolean,
            'email'                 => $this->faker->email,
            'phone'                 => $this->faker->phoneNumber,
            'phone_code'            => $country->calling_code,
//            'subscription_id'       => $subscription->isNotEmpty() ? new ObjectId($subscription->random(1)->first()->_id) : null,
            'darbi_percentage'      => mt_rand(10, 100),
            'country_id'            => new ObjectId($country->_id),
            'require_activation'    => $this->faker->boolean,
            'settings'              => [],
            'type'                  => ['car', 'yacht'][mt_rand(0,1)],
            'lat'                   => 21.509020,
            'lng'                   => 39.182270
        ];
    }
}

