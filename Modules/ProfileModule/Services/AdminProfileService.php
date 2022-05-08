<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\ProfileModule\Services;

use Illuminate\Support\Facades\Hash;
use Modules\ProfileModule\Transformers\AdminProfileResource;

class AdminProfileService
{
    private $guardName = 'admin_api';

    public function getProfile()
    {
        $me = auth($this->guardName)->user();

        return (new AdminProfileResource($me));
    }

    public function updateProfile($request)
    {
        $me = auth($this->guardName)->user();
        $me->name = $request->name;
        $me->email = $request->email;
        $me->password = Hash::make($request->password);
        $me->save();
        return (new AdminProfileResource($me));
    }
}
