<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasGym
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si no tiene gym_id y no está en la ruta de creación
        if (is_null($user->gym_id) && !$request->routeIs('admin.gyms.create', 'admin.gyms.store')) {
            return redirect()->route('admin.gyms.create')->with('message', 'Debe agregar un gimnasio antes de continuar');
        }

        return $next($request);
    }

}
