<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\User\UpdateProfileRequest;
use Modules\AuthModule\Http\Requests\User\UploadIdentityImageRequest;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Transformers\UserProfileResource;
use Modules\CommonModule\Traits\ImageHelperTrait;

class UserProfileService
{
    use ImageHelperTrait;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getProfile()
    {
        $me = auth('api')->user();

        if (!$me) {
            return serverErrorResponse();
        }

        return successResponse(['profile' => new UserProfileResource($me)]);
    }


    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $me = auth('api')->user();
        $me->name = $updateProfileRequest->name;

        $identity = (array)$me->identity ?? [];

        if ($updateProfileRequest->hasFile('identity_frontside_image')) {
            $identity['frontside_image'] = $this->uploadImage('identities', $updateProfileRequest->identity_frontside_image);
        }

        if ($updateProfileRequest->hasFile('identity_backside_image')) {
            $identity['backside_image'] = $this->uploadImage('identities', $updateProfileRequest->identity_backside_image);
        }

        $me->identity = $identity;

        //save data
        $me->save();

        return successResponse(['profile' => new UserProfileResource($me)], __('Your account has been updated'));
    }


    public function updateIdentityProfile(UploadIdentityImageRequest $identityImageRequest, $type)
    {
        $me = auth('api')->user();

        $identity = ['front' => 'frontside_image', 'back' => 'backside_image'];
        $property = $identity[$type];

        $myIdentity = (array)$me->identity ?? [];
        $path = $myIdentity[$property] = $this->uploadImage('identities', $identityImageRequest->image);

        $me->identity = $myIdentity;
        $me->save();

        return successResponse(['image' => imageUrl($path)], __('Identity has been uploaded successfully'));
    }


    public function removeIdentityProfile($type)
    {
        $me = auth('api')->user();

        $identity = ['front' => 'frontside_image', 'back' => 'backside_image'];
        $property = $identity[$type];

        $myIdentity = (array)$me->identity ?? [];
        $myIdentity[$property] = null;

        $me->identity = $myIdentity;
        $me->save();

        return successResponse(['image' => null], __('Identity removed successfully'));
    }


    public function deleteAccount()
    {
        $me = auth('api')->user();

        auth('api')->logout();

        $me->delete();

        return successResponse();
    }
}
