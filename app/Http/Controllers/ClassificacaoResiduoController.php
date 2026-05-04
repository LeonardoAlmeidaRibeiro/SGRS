<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassificacaoResiduoController extends Controller
{
    public function index()
    {
        $classificacoes = ClassificacaoResiduo::orderBy('nome')->get();

        return view('painel.classificacao_residuo.index', compact('classificacoes'));
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

        $classificacao = ClassificacaoResiduo::create($this->data($request, $validator->validated()));

        return response()->json([
            'success' => true,
            'message' => 'Classificacao cadastrada com sucesso!',
            'data' => $classificacao,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $classificacao = ClassificacaoResiduo::find($id);

        if (!$classificacao) {
            return response()->json([
                'success' => false,
                'message' => 'Classificacao nao encontrada.',
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->rules($classificacao->id), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $classificacao->update($this->data($request, $validator->validated()));

        return response()->json([
            'success' => true,
            'message' => 'Classificacao atualizada com sucesso!',
            'data' => $classificacao->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $classificacao = ClassificacaoResiduo::find($id);

        if (!$classificacao) {
            return response()->json([
                'success' => false,
                'message' => 'Classificacao nao encontrada.',
            ], 404);
        }

        try {
            $classificacao->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nao foi possivel excluir esta classificacao, pois ela esta vinculada a residuos.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Classificacao excluida com sucesso!',
        ]);
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classificacoes_residuo', 'nome')->ignore($ignoreId),
            ],
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('classificacoes_residuo', 'codigo')->ignore($ignoreId),
            ],
            'classe_nbr10004' => ['required', 'in:perigoso,nao_perigoso'],
            'codigo_cer' => ['nullable', 'string', 'max:50'],
            'exige_mtr' => ['nullable', 'boolean'],
            'exige_cadri' => ['nullable', 'boolean'],
        ];
    }

    private function data(Request $request, array $validated): array
    {
        $validated['exige_mtr'] = $request->boolean('exige_mtr');
        $validated['exige_cadri'] = $request->boolean('exige_cadri');

        return $validated;
    }

    private function messages(): array
    {
        return [
            'nome.required' => 'O nome e obrigatorio.',
            'nome.unique' => 'Este nome ja esta cadastrado.',
            'nome.max' => 'O nome deve ter no maximo 255 caracteres.',
            'codigo.required' => 'O codigo e obrigatorio.',
            'codigo.unique' => 'Este codigo ja esta cadastrado.',
            'codigo.max' => 'O codigo deve ter no maximo 50 caracteres.',
            'classe_nbr10004.required' => 'Informe a classe NBR 10004.',
            'classe_nbr10004.in' => 'Informe uma classe NBR 10004 valida.',
            'codigo_cer.max' => 'O codigo CER deve ter no maximo 50 caracteres.',
        ];
    }
}
