<?php

namespace App\Http\Controllers;

use App\Models\UnidadeMedida;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UnidadeMedidaController extends Controller
{
    public function index()
    {
        $unidades = UnidadeMedida::orderBy('nome')->get();

        return view('painel.unidadeMedida.index', compact('unidades'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['fator_conversao_para_kg'] = (float) $data['fator_conversao_para_kg'];

        $unidade = UnidadeMedida::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida cadastrada com sucesso!',
            'data' => $unidade,
            'id' => $unidade->id,
            'nome' => $unidade->nome,
            'fator_conversao_para_kg' => $unidade->fator_conversao_para_kg,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $unidade = UnidadeMedida::find($id);

        if (!$unidade) {
            return response()->json([
                'success' => false,
                'message' => 'Unidade de medida nao encontrada.',
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->rules($unidade->id), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['fator_conversao_para_kg'] = (float) $data['fator_conversao_para_kg'];

        $unidade->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida atualizada com sucesso!',
            'data' => $unidade->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $unidade = UnidadeMedida::find($id);

        if (!$unidade) {
            return response()->json([
                'success' => false,
                'message' => 'Unidade de medida nao encontrada.',
            ], 404);
        }

        try {
            $unidade->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nao foi possivel excluir esta unidade, pois ela esta vinculada a residuos.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Unidade de medida excluida com sucesso!',
        ]);
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('unidades_medida', 'nome')->ignore($ignoreId),
            ],
            'fator_conversao_para_kg' => ['required', 'numeric', 'min:0'],
        ];
    }

    private function messages(): array
    {
        return [
            'nome.required' => 'O nome e obrigatorio.',
            'nome.unique' => 'Este nome ja esta cadastrado.',
            'nome.max' => 'O nome deve ter no maximo 255 caracteres.',
            'fator_conversao_para_kg.required' => 'O fator de conversao e obrigatorio.',
            'fator_conversao_para_kg.numeric' => 'O fator de conversao deve ser um numero.',
            'fator_conversao_para_kg.min' => 'O fator nao pode ser negativo.',
        ];
    }
}
