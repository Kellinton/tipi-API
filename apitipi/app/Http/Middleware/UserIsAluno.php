<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsAluno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     // Verifica se o usuário autenticado é aluno.

    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user();

        if ($user && $user->tipo_usuario_type === 'aluno') {
            return $next($request);
        }

        return response()->json(['message' => 'Acesso negado. Somente alunos podem acessar esta área.'], 403);
    }
}
