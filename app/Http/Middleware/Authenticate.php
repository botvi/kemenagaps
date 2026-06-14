<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $user = $request->user();
        if ($user && $user->status === 'nonaktif') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            \RealRashid\SweetAlert\Facades\Alert::error('Akun Dinonaktifkan', 'Akun Anda telah dinonaktifkan oleh administrator.');
            return redirect()->route('login');
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
