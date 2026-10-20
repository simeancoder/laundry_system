<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Admin អាចចូលមើលបានគ្រប់ Route ទាំងអស់
        if ($user->isAdmin()) {
            return $next($request);
        }

        // ប្រសិនបើគ្មានបញ្ជាក់ role អ្វីទេ អនុញ្ញាតឱ្យចូល
        if (empty($roles)) {
            return $next($request);
        }

        // ពិនិត្យមើលថាតើ Role បច្ចុប្បន្នត្រូវនឹង Role ដែលបានអនុញ្ញាតដែរឬទេ
        $currentRole = strtolower($user->getCurrentRole());
        $allowedRoles = array_map('strtolower', $roles);

        if (in_array($currentRole, $allowedRoles, true)) {
            return $next($request);
        }

        abort(403, 'អ្នកគ្មានសិទ្ធិចូលប្រើប្រាស់ទំព័រនេះទេ។');
    }
}
