<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PerfilMiddleware
{
    public function handle(Request $request, Closure $next, ...$perfis)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return redirect()->route('painel.login');
        }

        if (!$usuario->temPerfil($perfis)) {
            return redirect()
                ->route('painel.home')
                ->with('swal_error', 'Voce nao tem permissao para acessar este recurso.');
        }

        return $next($request);
    }
}
