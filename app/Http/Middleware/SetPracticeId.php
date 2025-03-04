<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPracticeId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to switch-practice page

        if ($request->route()->getName() === 'filament.admin.pages.switch-practice') {
            return $next($request);
        }
        if (isset($request->pid)) {
            session(['practice_id' => request('pid')]);
            session(['pid_url' => true]);
        } elseif (! session()->has('practice_id') or session('practice_id') == null) {
            session()->flash('error', 'please select a practice');
            return redirect()->route('filament.admin.pages.switch-practice');
        }
        if ($request->user()->superadmin == 0) {
            $userAuthorizedPractices = $request->user()->userAuths()->where('role', '!=', 'none')->where('status', 1)->select('practice_id', 'role', 'status')->get();
            if (! $userAuthorizedPractices->contains('practice_id', session('practice_id'))) {
                session()->flash('error', 'please select a practice');
                return redirect()->route('filament.admin.pages.switch-practice');
            }
        }
        return $next($request);
    }
}
