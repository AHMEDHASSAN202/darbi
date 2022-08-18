<?php

namespace Modules\CatalogModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CatalogModule\Entities\Attribute;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Entity;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;
use MongoDB\BSON\ObjectId;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = [
            [
                'key'       => 'engine_type',
                'value'     => '4.0-liter V-8',
                'image'     => 'https://i.ibb.co/q0bSNT5/liter.png',
                'entity_type' => ['car'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'automatic',
                'value'     => 'Automatic',
                'image'     => 'https://i.ibb.co/8YFYNND/automatic.png',
                'entity_type' => ['car', 'yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'wheels',
                'value'     => 'All wheel drive',
                'image'     => 'https://i.ibb.co/TqMDkf4/wheels.png',
                'entity_type' => ['car'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'bags',
                'value'     => '2 Large Bags',
                'image'     => 'https://i.ibb.co/N7V7pCV/bags.png',
                'entity_type' => ['car'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'speed',
                'value'     => '0 - 100 kph 8.4 Sec',
                'image'     => 'https://i.ibb.co/cy6FT6Y/speed.png',
                'entity_type' => ['car', 'yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'seats',
                'value'     => '4 Seats',
                'image'     => 'https://i.ibb.co/stLWkxg/seats.png',
                'entity_type' => ['car'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'passengers',
                'value'     => '4 passengers',
                'image'     => 'https://i.ibb.co/nBjwmhP/passengers.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'captain',
                'value'     => 'Captain',
                'image'     => 'https://i.ibb.co/1vrxW5B/pilot.png',
                'entity_type' => ['car'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'bathing_ladder',
                'value'     => 'Bathing Ladder',
                'image'     => 'https://i.ibb.co/Q9psc4d/bathing-ladder.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'beds',
                'value'     => 'Beds',
                'image'     => 'https://i.ibb.co/Rzy85qr/bed.png',
                'entity_type' => ['yacht', 'villa'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'cabins',
                'value'     => 'Cabins',
                'image'     => 'https://i.ibb.co/DpW68yv/cabins.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'fuel_consumption',
                'value'     => 'Fuel Consumption',
                'image'     => 'https://i.ibb.co/YPkzkHc/fuel-consumption.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'guests_sleeping',
                'value'     => 'Guests Sleeping',
                'image'     => 'https://i.ibb.co/k3tjgqP/guests-sleeping.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'length',
                'value'     => 'Length',
                'image'     => 'https://i.ibb.co/QC0mj35/length.png',
                'entity_type' => ['yacht', 'car', 'villa'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'motor',
                'value'     => '30 Feet',
                'image'     => 'https://i.ibb.co/kMgwTZF/motor.png',
                'entity_type' => ['yacht'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'restrooms',
                'value'     => '3 Restrooms',
                'image'     => 'https://i.ibb.co/fFzrGtD/restrooms.png',
                'entity_type' => ['yacht', 'villa'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'guests',
                'value'     => '4 Guests',
                'image'     => 'https://i.ibb.co/nBjwmhP/guests.png',
                'entity_type' => ['villa'],
                'type'      => ['model', 'entity']
            ],
            [
                'key'       => 'pool',
                'value'     => 'Pool',
                'image'     => 'https://i.ibb.co/8KXR79d/pool.png',
                'entity_type' => ['villa'],
                'type'      => ['model', 'entity']
            ],
        ];


        Attribute::insert($assets);
    }
}
