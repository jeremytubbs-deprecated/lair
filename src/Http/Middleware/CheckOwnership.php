<?php

namespace Jeremytubbs\Lair\Http\Middleware;

use Closure;

class CheckOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {
        $superuser = config('lair.super_role');

        if ($request->user()->hasRole($superuser)) {
            return $next($request);
        }

        $user_id = \DB::table(str_plural($model))
                    ->where('slug', '=', $request->slug)->pluck('user_id');

        if ($request->user()->id == $user_id) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
