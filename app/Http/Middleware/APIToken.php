<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class APIToken
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
        if($request->header('Authorization')){

            $token = $request->header('Authorization');


            $user = User::where('api_token', $token)->first();

            if($user) {

                // Save USER info for the controller
                // https://laracasts.com/discuss/channels/laravel/reqeuest-attributes
                $request->attributes->add(['user' => $user]);
                return $next($request);

            } else {
                return response()->json([
                    'message' => 'User not found'
                ], 422);
            }

        }

        return response()->json([
            'message' => 'Not a valid API request.',
        ], 422);
    }
}
