<?php

namespace App\Http\Controllers;

use App\Models\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnidadeMedidaController extends Controller
{

    public function index()
    {
        $unidades = UnidadeMedida::all();
        return view('painel.unidadeMedida.index', compact('unidades'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            [
                'nome' => $request->nome,
                'fator_conversao_para_kg' => $request->fator_conversao_para_kg
            ],
            [
                'nome' => 'required|string|max:255|unique:unidades_medida,nome',
                'fator_conversao_para_kg' => 'required|numeric|min:0'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $unidade = UnidadeMedida::create([
            'nome' => $request->nome,
            'fator_conversao_para_kg' => $request->fator_conversao_para_kg,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida cadastrada com sucesso!',
            'id' => $unidade->id,
            'nome' => $unidade->nome,
            'fator_conversao_para_kg' => $unidade->fator_conversao_para_kg,
            'data' => $unidade
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $unidade = UnidadeMedida::find($id);

        if (!$unidade) {
            return response()->json([
                'success' => false,
                'message' => 'Unidade de medida não encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:unidades_medida,nome,',
            'fator_conversao_para_kg' => 'required|numeric|min:0'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.unique' => 'Este nome já está cadastrado.',
            'fator_conversao_para_kg.required' => 'O fator de conversão é obrigatório.',
            'fator_conversao_para_kg.numeric' => 'O fator de conversão deve ser um número.',
            'fator_conversao_para_kg.min' => 'O fator não pode ser negativo.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $unidade->update([
            'nome' => $request->nome,
            'fator_conversao_para_kg' => (float) $request->fator_conversao_para_kg
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida atualizada com sucesso!',
            'data' => $unidade
        ]);
    }

    public function destroy($id)
    {
        $unidade = UnidadeMedida::find($id);

        if (!$unidade) {
            return response()->json([
                'success' => false,
                'message' => 'Unidade de medida não encontrada'
            ], 404);
        }

        $unidade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida excluída com sucesso!'
        ]);
    }
}
