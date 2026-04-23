<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassificacaoResiduoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classificacoes = ClassificacaoResiduo::all();
        return response()->json([
            'success' => true,
            'data' => $classificacoes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:classificacoes_residuo',
            'codigo' => 'required|string|max:50',
            'exige_mtr' => 'boolean',
            'exige_cadri' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $classificacao = ClassificacaoResiduo::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Classificação cadastrada com sucesso!',
            'data' => $classificacao
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $classificacao = ClassificacaoResiduo::find($id);

        if (!$classificacao) {
            return response()->json([
                'success' => false,
                'message' => 'Classificação não encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $classificacao
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $classificacao = ClassificacaoResiduo::find($id);

        if (!$classificacao) {
            return response()->json([
                'success' => false,
                'message' => 'Classificação não encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nome' => 'sometimes|string|max:255|unique:classificacoes_residuo,nome,' . $id,
            'codigo' => 'sometimes|string|max:50',
            'exige_mtr' => 'sometimes|boolean',
            'exige_cadri' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $classificacao->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Classificação atualizada com sucesso!',
            'data' => $classificacao
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classificacao = ClassificacaoResiduo::find($id);

        if (!$classificacao) {
            return response()->json([
                'success' => false,
                'message' => 'Classificação não encontrada'
            ], 404);
        }

        $classificacao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Classificação excluída com sucesso!'
        ]);
    }
}