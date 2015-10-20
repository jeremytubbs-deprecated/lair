<?php

namespace Jeremytubbs\Lair\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $guarded = ['id'];

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
