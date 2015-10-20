<?php

namespace Jeremytubbs\Lair;

use Exception;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Cache\Repository;
use Log;
use Jeremytubbs\Lair\Models\Permission;

class Lair
{
    /**
     * @var Gate
     */
    protected $gate;

    /**
     * @var Repository
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey = 'lair.permission.cache';

    /**
     * @param Gate       $gate
     * @param Repository $cache
     */
    public function __construct(Gate $gate, Repository $cache)
    {
        $this->gate = $gate;
        $this->cache = $cache;
    }

    /**
     *  Register the permissions.
     *
     * @return bool
     */
    public function registerPermissions()
    {
        try {
            $this->getPermissions()->map(function ($permission) {

                $this->gate->before(function ($user, $ability) {
                    if ($user->hasRole(config('lair.super_role'))) {
                        return true;
                    }
                });

                $this->gate->define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });

            });

            return true;
        } catch (Exception $e) {
            Log::alert('Could not register permissions');

            return false;
        }
    }

    /**
     *  Forget the cached permissions.
     */
    public function forgetCachedPermissions()
    {
        $this->cache->forget($this->cacheKey);
    }

    /**
     * Get the current permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return $this->cache->rememberForever($this->cacheKey, function () {
            return Permission::with('roles')->get();
        });
    }
}
