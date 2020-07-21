<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $APIToken = $request->bearerToken();

        if (!$APIToken) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = User::query()->where('api_token', '=', $APIToken)->first();

        if ($user) {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            return $next($request);
        }


        return response()->json(['message' => 'Unauthenticated'], 401);
    }
}
