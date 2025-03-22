<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Users;
use App\Models\SchoolInfo;
use App\Models\UserGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class LoginData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the route exists; skip sharing data for non-existing routes
        if (!$request->route() || $request->route()->getName() === '404') {
            return $next($request);
        }


        $schoolInfo = SchoolInfo::first();
        $userData = null;

        if (session()->has('user_data')) {
            $userData = json_decode(Crypt::decryptString(session('user_data')), true);
            $userGroup = UserGroups::find($userData['uGroup']);
            $user = Users::find($userData['userId']);
        }

        View::share([
            'pageTitle' => $schoolInfo->schoolabvname . " Administrative Dashboard",
            'schoolName' => $schoolInfo->schoolname,
            'schoolAbvName' => $schoolInfo->schoolabvname,
            'userData' => $userData ?? null,
            'userGroup' => $userGroup ?? null,
            'user' => $user ?? null,
        ]);

        return $next($request);
    }
}
