<?php

namespace App\Http\Middleware;

use Closure;

class HandleCors
{
    // public function handle($request, Closure $next)
    // {
    //     $response = $next($request);

    //     $response->headers->set('Access-Control-Allow-Credentials', 'true');
    //     $response->headers->set('Access-Control-Allow-Origin', '*');
    //     $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    //     $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With');

    //     return $response;
    // }

    public function handle($request, Closure $next)
    {
        // Se a requisição for um preflight (OPTIONS), retorne uma resposta vazia com os headers de CORS
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, [
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, X-Requested-With',
            ]);
        }

        $response = $next($request);

        // Adiciona os cabeçalhos CORS
        // $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With');

        return $response;
    }
}
