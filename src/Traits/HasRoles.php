<?php

namespace Jeremytubbs\Lair\Traits;

use Jeremytubbs\Lair\Models\Permission;
use Jeremytubbs\Lair\Models\Role;

trait HasRoles
{
    use RefreshesPermissionCache;

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * Remove the given role from the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function removeRole($role)
    {
        return $this->roles()->detach(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    /**
     * Determine if the user owns the resource.
     *
     * @param  mixed $id
     * @return boolean
     */
    public function isOwner($id)
    {
        return $this->id == $id;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission)
    {
        return $this->hasRole($permission->roles);
    }
}

