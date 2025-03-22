<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Policies\MenuPolicy;
use Illuminate\Support\Facades\Crypt;

class CheckUserAccess
{
    protected $policy;

    public function __construct()
    {
        $this->policy = new MenuPolicy();
    }

    public function handle(Request $request, Closure $next, $permission)
    {
        $userData = session('user_data');

        if ($userData) {
            $decryptedUserData = json_decode(Crypt::decryptString($userData), true);

            // Check if user has the specified permission in the policy
            if (method_exists($this->policy, $permission) && $this->policy->$permission($decryptedUserData)) {
                return $next($request);
            }
        }

        // If access is denied, redirect to a specific page or show 403 Forbidden
        return redirect('/forbidden')->with('error', 'Access denied');
    }
}
