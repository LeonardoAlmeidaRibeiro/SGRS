<?php

namespace App\Http\Controllers;

use App\Models\Residuo;
use App\Models\Empresa;
use App\Models\ClassificacaoResiduo;
use App\Models\UnidadeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ResiduoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Residuo::with(['empresa', 'classificacao', 'unidade']);
        
        // Filtros
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('classificacao_id')) {
            $query->where('classificacao_id', $request->classificacao_id);
        }
        
        if ($request->has('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }
        
        if ($request->has('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }
        
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->has('tipo_material')) {
            $query->where('tipo_material', 'like', '%' . $request->tipo_material . '%');
        }
        
        $residuos = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $residuos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required|exists:empresas,id',
            'classificacao_id' => 'required|exists:classificacoes_residuo,id',
            'tipo_material' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'quantidade' => 'required|numeric|min:0',
            'unidade_id' => 'required|exists:unidades_medida,id',
            'status' => 'in:disponivel,reservado,finalizado',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $residuo = Residuo::create($request->all());
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Resíduo cadastrado com sucesso!',
                'data' => $residuo->load(['empresa', 'classificacao', 'unidade'])
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar resíduo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $residuo = Residuo::with(['empresa', 'classificacao', 'unidade'])->find($id);

        if (!$residuo) {
            return response()->json([
                'success' => false,
                'message' => 'Resíduo não encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $residuo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return response()->json([
                'success' => false,
                'message' => 'Resíduo não encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'empresa_id' => 'sometimes|exists:empresas,id',
            'classificacao_id' => 'sometimes|exists:classificacoes_residuo,id',
            'tipo_material' => 'sometimes|string|max:255',
            'descricao' => 'nullable|string',
            'quantidade' => 'sometimes|numeric|min:0',
            'unidade_id' => 'sometimes|exists:unidades_medida,id',
            'status' => 'sometimes|in:disponivel,reservado,finalizado',
            'endereco' => 'sometimes|string|max:255',
            'cidade' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:2',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            
            $residuo->update($request->all());
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Resíduo atualizado com sucesso!',
                'data' => $residuo->load(['empresa', 'classificacao', 'unidade'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar resíduo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return response()->json([
                'success' => false,
                'message' => 'Resíduo não encontrado'
            ], 404);
        }

        try {
            DB::beginTransaction();
            
            $residuo->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Resíduo excluído com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir resíduo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update status of residuo
     */
    public function updateStatus(Request $request, $id)
    {
        $residuo = Residuo::find($id);

        if (!$residuo) {
            return response()->json([
                'success' => false,
                'message' => 'Resíduo não encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:disponivel,reservado,finalizado'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $residuo->status = $request->status;
        $residuo->save();

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'data' => $residuo
        ]);
    }

    /**
     * Get residuos by location
     */
    public function getByLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|string|max:2',
            'cidade' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('estado', $request->estado)
            ->where('status', 'disponivel');

        if ($request->has('cidade')) {
            $query->where('cidade', $request->cidade);
        }

        $residuos = $query->get();

        return response()->json([
            'success' => true,
            'data' => $residuos
        ]);
    }

    /**
     * Get statistics about residuos
     */
    public function getStatistics()
    {
        $totalDisponivel = Residuo::where('status', 'disponivel')->count();
        $totalReservado = Residuo::where('status', 'reservado')->count();
        $totalFinalizado = Residuo::where('status', 'finalizado')->count();
        
        $totalQuantidade = Residuo::sum('quantidade');
        
        $porClassificacao = Residuo::with('classificacao')
            ->select('classificacao_id', DB::raw('count(*) as total'))
            ->groupBy('classificacao_id')
            ->get();
        
        $porEstado = Residuo::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_disponivel' => $totalDisponivel,
                'total_reservado' => $totalReservado,
                'total_finalizado' => $totalFinalizado,
                'total_quantidade' => $totalQuantidade,
                'por_classificacao' => $porClassificacao,
                'por_estado' => $porEstado
            ]
        ]);
    }
}