<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyInactivityToken
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $login = \Auth::user();
        if ($login) {
            /**
             * @var $currentAccessToken PersonalAccessToken
             */
            $currentAccessToken = $login->currentAccessToken();
            $expiredInactivity = Carbon::parse($currentAccessToken->expired_inactivity_at);

            if (Carbon::now()->greaterThan($expiredInactivity)) {
                $currentAccessToken->delete();
                throw new AuthenticationException();
            }
        }
        return $next($request);
    }
}
