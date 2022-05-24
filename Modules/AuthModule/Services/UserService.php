<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\CommonModule\Traits\ImageHelperTrait;

class UserService
{
    use ImageHelperTrait;

    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
