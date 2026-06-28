<?php
namespace VanguardLTE\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class CheckSelfExclusion {
    public function handle(Request $request, Closure $next) {
        if (Auth::check()) {
            $excl = \VanguardLTE\SelfExclusion::where('user_id', Auth::id())
                ->where(function($q) { $q->whereNull('ends_at')->orWhere('ends_at','>',now()); })->first();
            if ($excl) {
                Auth::logout(); $request->session()->invalidate();
                $msg = $excl->ends_at ? 'Account excluded until: '.$excl->ends_at : 'Account permanently excluded.';
                return redirect('/')->withErrors($msg);
            }
        }
        return $next($request);
    }
}
