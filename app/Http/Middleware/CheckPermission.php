<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $menuName)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            // Check if the user has permission for the given menu_name
            $hasPermission = Permission::where('user_id', $user->id)
                ->where('menu_name', $menuName)
                ->exists();

            if (!$hasPermission) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        return $next($request);
    }
}
