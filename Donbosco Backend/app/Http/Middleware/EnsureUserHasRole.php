<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            abort(401, __('messages.unauthorized'));
        }

        $rolesMap = [
            'user' => 4,
        ];

        if ($request->user()->role !== ($rolesMap[$role] ?? null)) {
            abort(403, __('messages.unauthorized_role'));
        }

        return $next($request);
    }
}
