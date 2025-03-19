<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserBelongsToTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->input('tenant_id') ?? session('tenant_id');

        if (!$tenantId) {
            return response()->json(['message' => 'Tenant ID is required'], 400);
        }

        $request->merge(['tenant_id' => $tenantId]);

        if ($request->route('tenant_id') && $request->route('tenant_id') != $tenantId) {
            return response()->json(['message' => 'Unauthorized access to tenant resources'], 403);
        }

        return $next($request);
    }
}