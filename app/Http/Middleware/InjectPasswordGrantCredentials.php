<?php

// From https://laracasts.com/discuss/channels/code-review/api-authentication-with-passport
//   resolves issue of SPA having to send a secret

namespace App\Http\Middleware;

use DB;
use Closure;

class InjectPasswordGrantCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        info(__METHOD__);
        if ($request->grant_type == 'password') {
            $client = DB::table('oauth_clients')
                ->where('id', env('PASSWORD_CLIENT_ID'))
                ->first();

            $request->request->add([
                'client_id' => $client->id,
                'client_secret' => $client->secret,
            ]);
        }

        return $next($request);
    }
}
