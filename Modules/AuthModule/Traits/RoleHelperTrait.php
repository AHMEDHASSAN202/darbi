<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Traits;


use Modules\AuthModule\Entities\Role;

trait RoleHelperTrait
{
    //============= Relations ===================\\
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    //============= #END# Relations ===================\\

    public function hasPermissions($permission)
    {
        $permissions = is_array($permission) ? $permission : [$permission];
        $rolePermissions = optional($this->role)->permissions;
        $myPermissions = is_array($rolePermissions) ? $rolePermissions : (json_decode($rolePermissions) ?? []);
        foreach ($permissions as $per) {
            if (!in_array($per, $myPermissions)) {
                return false;
            }
        }
        return true;
    }
}
