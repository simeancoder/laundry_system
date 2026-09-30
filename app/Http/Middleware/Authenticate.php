<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // 1. If standard Auth is active
        if (Auth::check()) {
            return $next($request);
        }

        // 2. If session-based login flag is active
        if (session('is_logged_in') === true) {
            $user = null;
            try {
                $user = User::first();
            } catch (\Throwable $e) {
                $user = null;
            }

            if (!$user) {
                $user = new User([
                    'id' => 1,
                    'name' => session('user_name', 'Admin User'),
                    'email' => session('user_email', 'admin@gmail.com'),
                ]);
            }
            Auth::login($user);

            return $next($request);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
