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
        return view('painel.classificacao_residuo.index', compact('classificacoes'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nome' => 'required|string|max:255|unique:classificacoes_residuo',
                'codigo' => 'required|string|max:50|unique:classificacoes_residuo',
                'exige_mtr' => 'boolean',
                'exige_cadri' => 'boolean'
            ],
            [
                'nome.required' => 'O nome é obrigatório.',
                'nome.unique' => 'Este nome já está cadastrado.',

                'codigo.required' => 'O código é obrigatório.',
                'codigo.unique' => 'Este código já está cadastrado.',

                'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
                'codigo.max' => 'O código deve ter no máximo 50 caracteres.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $data = $request->all();
        $data['exige_mtr'] = $request->boolean('exige_mtr');
        $data['exige_cadri'] = $request->boolean('exige_cadri');

        $classificacao = ClassificacaoResiduo::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Classificação cadastrada com sucesso!',
            'data' => $classificacao
        ], 201);
    }

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
