<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * ✅ هذا الميدلوير يمنع الدخول لصفحات الأدمن إلا إذا كان المستخدم Admin
     */
    public function handle(Request $request, Closure $next)
    {
        // ✅ نجيب المستخدم الحالي من الـ request
        $user = $request->user();

        // ✅ إذا ماكانش مسجل دخول
        if (!$user) {
            abort(403, 'Accès refusé.');
        }

        // ✅ إذا مسجل دخول لكن ماشي Admin
        if (!$user->is_admin) {
            abort(403, 'Accès refusé (Admin seulement).');
        }

        return $next($request);
    }
}
