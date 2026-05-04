<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use App\Models\Empresa;
use App\Models\Residuo;
use App\Models\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResiduoController extends Controller
{
    public function index(Request $request)
    {
        $query = Residuo::with(['empresa', 'classificacao', 'unidade']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('classificacao_id')) {
            $query->where('classificacao_id', $request->classificacao_id);
        }

        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }

        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_material')) {
            $query->where('tipo_material', 'like', '%' . $request->tipo_material . '%');
        }

        $residuos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $classificacoes = ClassificacaoResiduo::orderBy('nome')->get();
        $empresas = Empresa::orderBy('nome')->get();

        return view('painel.residuos.index', compact('residuos', 'classificacoes', 'empresas'));
    }

    public function create()
    {
        return view('painel.residuos.criar', $this->formOptions());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            Residuo::create($this->data($validator->validated()));

            DB::commit();

            return redirect()
                ->route('residuos.index')
                ->with('swal_success', 'Resíduo cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('swal_error', 'Erro ao cadastrar resíduo: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $residuo = Residuo::with(['empresa', 'classificacao', 'unidade'])->find($id);

        if (!$residuo) {
            return redirect()
                ->route('residuos.index')
                ->with('swal_error', 'Resíduo não encontrado.');
        }

        return view('painel.residuos.visualizar', compact('residuo'));
    }

    public function edit($id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return redirect()
                ->route('residuos.index')
                ->with('swal_error', 'Resíduo não encontrado.');
        }

        return view('painel.residuos.editar', array_merge(
            ['residuo' => $residuo],
            $this->formOptions()
        ));
    }

    public function update(Request $request, $id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return redirect()
                ->route('residuos.index')
                ->with('swal_error', 'Resíduo não encontrado.');
        }

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $residuo->update($this->data($validator->validated()));

            DB::commit();

            return redirect()
                ->route('residuos.index')
                ->with('swal_success', 'Resíduo atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('swal_error', 'Erro ao atualizar resíduo: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return redirect()
                ->route('residuos.index')
                ->with('swal_error', 'Resíduo não encontrado.');
        }

        try {
            $residuo->delete();

            return redirect()
                ->route('residuos.index')
                ->with('swal_success', 'Resíduo excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->route('residuos.index')
                ->with('swal_error', 'Erro ao excluir resíduo: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return response()->json([
                'success' => false,
                'message' => 'Resíduo não encontrado.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:disponivel,reservado,finalizado',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $residuo->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'data' => $residuo->fresh(),
        ]);
    }

    public function getByLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|string|max:2',
            'cidade' => 'nullable|string|max:255',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('estado', $request->estado)
            ->where('status', 'disponivel');

        if ($request->filled('cidade')) {
            $query->where('cidade', $request->cidade);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get(),
        ]);
    }

    public function getStatistics()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_disponivel' => Residuo::where('status', 'disponivel')->count(),
                'total_reservado' => Residuo::where('status', 'reservado')->count(),
                'total_finalizado' => Residuo::where('status', 'finalizado')->count(),
                'total_quantidade' => Residuo::sum('quantidade'),
                'por_classificacao' => Residuo::with('classificacao')
                    ->select('classificacao_id', DB::raw('count(*) as total'))
                    ->groupBy('classificacao_id')
                    ->get(),
                'por_estado' => Residuo::select('estado', DB::raw('count(*) as total'))
                    ->groupBy('estado')
                    ->get(),
            ],
        ]);
    }

    private function formOptions(): array
    {
        return [
            'empresas' => Empresa::orderBy('nome')->get(),
            'classificacoes' => ClassificacaoResiduo::orderBy('nome')->get(),
            'unidades' => UnidadeMedida::orderBy('nome')->get(),
            'statusOptions' => $this->statusOptions(),
        ];
    }

    private function rules(): array
    {
        return [
            'empresa_id' => ['nullable', 'exists:empresas,id'],
            'classificacao_id' => ['required', 'exists:classificacoes_residuo,id'],
            'tipo_material' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'imagem' => ['nullable', 'url', 'max:255'],
            'quantidade' => ['required', 'numeric', 'min:0'],
            'unidade_id' => ['required', 'exists:unidades_medida,id'],
            'status' => ['required', 'in:disponivel,reservado,finalizado'],
            'endereco' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'size:2'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    private function data(array $validated): array
    {
        if (empty($validated['empresa_id']) && Auth::check()) {
            $validated['empresa_id'] = Auth::user()->empresa_id;
        }

        $validated['estado'] = strtoupper($validated['estado']);

        return $validated;
    }

    private function messages(): array
    {
        return [
            'empresa_id.exists' => 'Informe uma empresa válida.',
            'classificacao_id.required' => 'A classificação é obrigatória.',
            'classificacao_id.exists' => 'Informe uma classificação válida.',
            'tipo_material.required' => 'O tipo de material é obrigatório.',
            'tipo_material.max' => 'O tipo de material deve ter no máximo 255 caracteres.',
            'imagem.url' => 'Informe uma URL de imagem válida.',
            'imagem.max' => 'A URL da imagem deve ter no máximo 255 caracteres.',
            'quantidade.required' => 'A quantidade é obrigatória.',
            'quantidade.numeric' => 'A quantidade deve ser um número.',
            'quantidade.min' => 'A quantidade não pode ser negativa.',
            'unidade_id.required' => 'A unidade de medida é obrigatória.',
            'unidade_id.exists' => 'Informe uma unidade de medida válida.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Informe um status válido.',
            'endereco.required' => 'O endereço é obrigatório.',
            'endereco.max' => 'O endereço deve ter no máximo 255 caracteres.',
            'cidade.required' => 'A cidade é obrigatória.',
            'cidade.max' => 'A cidade deve ter no máximo 255 caracteres.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.size' => 'O estado deve ter 2 letras.',
            'latitude.numeric' => 'A latitude deve ser um número.',
            'latitude.between' => 'A latitude deve estar entre -90 e 90.',
            'longitude.numeric' => 'A longitude deve ser um número.',
            'longitude.between' => 'A longitude deve estar entre -180 e 180.',
        ];
    }

    private function statusOptions(): array
    {
        return [
            'disponivel' => 'Disponível',
            'reservado' => 'Reservado',
            'finalizado' => 'Finalizado',
        ];
    }
}
