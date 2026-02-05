<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $menuKey): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has access to the menu
        if (!hasMenuAccess($menuKey)) {
            // Flash message for better UX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to access this menu.',
                    'status' => 'forbidden'
                ], 403);
            }

            // Prevent duplicate messages by checking if already set
            if (!session()->has('access_error_shown')) {
                return redirect()->route('dashboard')
                    ->with('error', 'You do not have permission to access this menu.')
                    ->with('access_error_shown', true);
            } else {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
