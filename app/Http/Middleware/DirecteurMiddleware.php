<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DirecteurMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'message' => 'Accès refusé. Réservé à la direction.',
            ], 403);
        }

        return $next($request);
    }
}
