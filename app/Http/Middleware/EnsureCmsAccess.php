<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Only users that have at least one role can enter the CMS.
 * What they can do inside is decided per module by permissions.
 */
class EnsureCmsAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->roles->isEmpty()) {
            abort(403, 'Your account has no CMS role assigned.');
        }

        return $next($request);
    }
}
