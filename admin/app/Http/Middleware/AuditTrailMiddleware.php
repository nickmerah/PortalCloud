<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AuditTrailMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user_data')) {
            $userData = json_decode(Crypt::decryptString(session('user_data')), true);
        }

        // Proceed with the request to allow it to reach the controller
        $response = $next($request);

        // Capture audit details
        $auditData = [
            'user_id' => $userData['userId'],
            'action' => $request->method(),
            'table_name' => $request->route()->getName() ?? 'login',
            'record_id' => request()->url(),
            'old_data' => null,
            'new_data' => $request->except(['_token', 'password']),
            'created_at' => now(),
            'updated_at' => now(),
        ];


        // Save to the audits table
        Audit::create($auditData);

        return $response;
    }
}
