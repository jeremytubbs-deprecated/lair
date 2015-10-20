<?php

namespace Jeremytubbs\Lair\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = null)
    {
        $superuser = config('lair.super_role');

        // user is the superuser
        if ($request->user()->hasRole($superuser)) {
            return $next($request);
        }

        // no permissions are set
        if (!$permissions) {
            return $next($request);
        }

        // split permissions on a pipe
        $permissions = strpos($permissions,'|') !== true ? explode("|", $permissions) : (array) $permissions;

        foreach ($permissions as $permission) {
            if($request->user()->hasPermission($permissions)) {
                return $next($request);
            }
        }

        return response('Unauthorized.', 401);
    }

}
