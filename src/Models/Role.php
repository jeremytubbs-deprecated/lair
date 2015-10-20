<?php

namespace Jeremytubbs\Lair\Models;

use Illuminate\Database\Eloquent\Model;
use Jeremytubbs\Lair\Traits\RefreshesPermissionCache;

class Role extends Model
{
    use RefreshesPermissionCache;

    public $guarded = ['id'];

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Grant the given permission to a role.
     *
     * @param  $permission
     * @return mixed
     */
    public function assignPermission($permission)
    {
        return $this->permissions()->save(
            Permission::whereName($permission)->firstOrFail()
        );
    }

    /**
     * Revoke the given permission.
     *
     * @param $permission
     * @return mixed
     */
    public function removePermission($permission)
    {
        return $this->permissions()->detach(
            Permission::whereName($permission)->firstOrFail()
        );
    }

}
