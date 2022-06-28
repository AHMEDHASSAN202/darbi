<?php

namespace Modules\CatalogModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Entity;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;
use MongoDB\BSON\ObjectId;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Riyadh = City::where('code', 'RD')->first();
        $Makkah = City::where('code', 'ML')->first();
        $Dubai = City::where('code', 'DU')->first();
        $Tabuk = City::where('code', 'TB')->first();

//        Region::create([
//            'name'      => ['ar' => 'الرياض', 'en' => 'Riyadh'],
//            'city_id'   => new ObjectId($Riyadh->_id),
//            'country_id'=> new ObjectId($Riyadh->country_id),
//            'location'  => [
//                'type'          => 'Polygon',
//                'coordinates'   => [
//                    [
//                        [44.3759747, 28.0862228],
//                        [41.5634747, 25.6944023],
//                        [42.5742169, 23.1323178],
//                        [44.3759747, 19.3630657],
//                        [47.5839825, 19.2800814],
//                        [48.7265606, 23.4553948],
//                        [44.3759747, 28.0862228],
//                    ]
//                ]
//            ],
//            'is_active' => true
//        ]);
//
//        Region::create([
//            'name'      => ['ar' => 'مكة', 'en' => 'Makkah'],
//            'city_id'   => new ObjectId($Makkah->_id),
//            'country_id'=> new ObjectId($Makkah->country_id),
//            'location'  => [
//                'type'          => 'Polygon',
//                'coordinates'   => [
//                    [
//                        [38.5488287, 23.7219583],
//                        [41.0976568, 23.9029737],
//                        [42.5917974, 22.7117756],
//                        [42.9433599, 21.0389417],
//                        [40.4165044, 20.0508264],
//                        [38.5048833, 23.7018299],
//                        [38.5488287, 23.7219583],
//                    ]
//                ]
//            ],
//            'is_active' => true
//        ]);
//
//        Region::create([
//            'name'      => ['ar' => 'دبي', 'en' => 'Dubai'],
//            'city_id'   => new ObjectId($Dubai->_id),
//            'country_id'=> new ObjectId($Dubai->country_id),
//            'location'  => [
//                'type'          => 'Polygon',
//                'coordinates'   => [
//                    [
//                        [55.4880982, 25.457473],
//                        [55.6556397, 25.3407993],
//                        [55.6281739, 25.2339567],
//                        [55.4688722, 25.1170677],
//                        [55.2821046, 25.0448888],
//                        [55.1722413, 25.1145795],
//                        [55.4880982, 25.457473],
//                    ]
//                ]
//            ],
//            'is_active' => true
//        ]);

        Region::create([
            'name'      => ['ar' => 'Tabuk', 'en' => 'Tabuk'],
            'city_id'   => new ObjectId($Tabuk->_id),
            'country_id'=> new ObjectId($Tabuk->country_id),
            'location'  => [
                'type'          => 'Polygon',
                'coordinates'   => [
                    [
                        [30.9729652, 30.0896107],
                        [31.0062675, 30.0515599],
                        [31.0287552, 30.0271759],
                        [30.9830933, 30.0048682],
                        [30.9293633, 30.0668711],
                        [30.9449844, 30.0841121],
                        [30.9729652, 30.0896107],
                    ]
                ]
            ],
            'is_active' => true
        ]);
    }
}
