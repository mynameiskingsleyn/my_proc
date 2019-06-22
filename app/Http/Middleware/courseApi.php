<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class courseApi
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
        $reqToken = $request->get('api_token');
        if ($reqToken) {
            $tokenMatch = User::matchToken($reqToken);
            if (!$tokenMatch) {
                return response()->json(['error'=>'Unauthorized user'], 401);
            }
        } else {
            return response()->json(['error'=>'Unauthorized user'], 401);
        }


        return $next($request);
    }
}
