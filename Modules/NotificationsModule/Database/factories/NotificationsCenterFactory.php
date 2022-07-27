<?php

namespace Modules\NotificationsModule\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AuthModule\Entities\User;
use MongoDB\BSON\ObjectId;

class NotificationsCenterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\NotificationsModule\Entities\NotificationsCenter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $allUsers = User::all();
        $user = $allUsers->random(1)->first();
        $receiver = $allUsers->random(1)->first();

        return [
            'triggered_by'  => ['is_automatic' => $this->faker->boolean, 'user_id' => new ObjectId($user->_id), 'on_model' => 'user'],
            'receivers'      => [['user_id' => new ObjectId($receiver->_id), 'on_model' => 'user']],
            'notification_type' => ['offer', 'booking'][mt_rand(0,1)],
            'title'         => ['en' => $this->faker->text(50), 'ar' => $arFaker->text(50)],
            'message'       => ['en' => $this->faker->text(), 'ar' => $arFaker->text()],
            'url'           => null,
            'image'         => null
        ];
    }
}

