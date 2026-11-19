<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Uso: ->middleware('role:admin') o ->middleware('role:admin,mecanico')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user && $user->hasRole(...array_map(Role::from(...), $roles)), 403);

        return $next($request);
    }
}
