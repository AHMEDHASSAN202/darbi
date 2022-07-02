<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Transformers\AdminProfileResource;
use Modules\CommonModule\Traits\ImageHelperTrait;

class AdminProfileService
{
    use ImageHelperTrait;

    private $guardName = 'admin_api';

    public function getProfile()
    {
        $me = auth($this->guardName)->user()->load('role');

        return (new AdminProfileResource($me));
    }

    public function updateProfile($request)
    {
        $me = auth($this->guardName)->user();
        $me->name = $request->name;
        $me->email = $request->email;

        if ($request->password) {
            $me->password = Hash::make($request->password);
        }

        $oldImage = null;
        if ($request->hasFile('image')) {
            $oldImage = $me->image;
            $me->image = $this->uploadImage('admins', $request->image);
        }

        $me->save();

        $this->_removeImage($oldImage);

        return (new AdminProfileResource($me));
    }
}
