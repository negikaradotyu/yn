<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowGuestAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 特定のルート（例: welcome）に対してログイン制御を無効にする
        
        //dd('Reached the allow.guest middleware for "home" route.', $request->routeIs('home'));
        if ($request->routeIs('index')) {
            return $next($request);
        }
        //dd('Reached the allow.guest middleware for "home" route.', $request->routeIs('home'));

        if ($request->routeIs('post')) {
            return $next($request);
        }

        if ($request->routeIs('category')) {
            return $next($request);
        }

        if ($request->routeIs('keijiban')) {
            return $next($request);
        }
        if ($request->routeIs('search')) {
            return $next($request);
        }
        if ($request->routeIs('topten')) {
            return $next($request);
        }
        if ($request->routeIs('kekka4')) {
            return $next($request);
        }
        // ログイン状態をチェックし、制御を行う
        if (auth()->check()) {
            return $next($request);
        }

        return redirect('/login'); // ログインしていない場合はログインページにリダイレクト
    }
}
