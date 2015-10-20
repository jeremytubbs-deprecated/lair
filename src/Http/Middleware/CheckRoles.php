<?php

namespace Jeremytubbs\Lair\Http\Middleware;

use Closure;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null)
    {
        $superuser = config('lair.super_role');

        // user is the superuser
        if ($request->user()->hasRole($superuser)) {
            return $next($request);
        }

        // no roles are set
        if (!$roles) {
            return $next($request);
        }

        // split roles on a pipe
        $roles = strpos($roles,'|') !== true ? explode("|", $roles) : (array) $roles;

        foreach ($roles as $role) {
            if($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        return response('Unauthorized.', 401);
    }
}
