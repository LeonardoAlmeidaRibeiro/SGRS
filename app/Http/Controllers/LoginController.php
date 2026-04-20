<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function cadastro()
    {

        $estados = Estado::all();
        $cidades = Cidade::all();
        return view('cadastro', compact('estados', 'cidades'));
    }


    public function buscarPorNome(Request $request)
    {
        $cidadeNome = $request->cidade;
        $uf = $request->uf;

        // Busca o estado pela sigla OU pelo nome
        $estado = Estado::where('sigla', $uf)
            ->orWhere('nome', 'LIKE', "%{$uf}%")
            ->first();

        if (!$estado) {
            return response()->json([
                'estado_id' => null,
                'cidade_id' => null,
                'estado_nome' => null,
                'cidade_nome' => null
            ]);
        }

        // Busca a cidade
        $cidade = Cidade::where('nome', $cidadeNome)
            ->where('estado_id', $estado->id)
            ->first();

        if (!$cidade) {
            $cidade = Cidade::where('nome', 'LIKE', "%{$cidadeNome}%")
                ->where('estado_id', $estado->id)
                ->first();
        }

        return response()->json([
            'estado_id' => $estado->id,
            'estado_nome' => $estado->nome,
            'estado_sigla' => $estado->sigla, // Adicione isso
            'cidade_id' => $cidade ? $cidade->id : null,
            'cidade_nome' => $cidade ? $cidade->nome : null
        ]);
    }
}
