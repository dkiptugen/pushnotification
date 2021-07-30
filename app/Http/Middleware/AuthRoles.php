<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use App\Exceptions\UnauthorizedException;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class AuthRoles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {

        $guard = auth('api')->check() ? 'api' : '';

        throw_if(!auth($guard)->check(), UnauthenticatedException::notLoggedIn());

        $action = $request->route()->getActionname();
        $name = $request->route()->getActionname();

        $role_id = auth($guard)->user()->role_id;

        $permission = Permission::where(function ($query)use ($action, $name){
            $query->where('name', $name);
            $query->orWhere('action', $action);
        })->whereHas('roles', function ($query) use($role_id){
            $query->where('id',$role_id);
        })->first();

        throw_if(is_null($permission), UnauthorizedException::noPermission());

        return $next($request);
    }
}
