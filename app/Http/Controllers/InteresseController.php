<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use App\Models\Empresa;
use App\Models\Interesse;
use App\Models\Residuo;
use App\Services\MatchInteligenteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InteresseController extends Controller
{
    public function index()
    {
        $interesses = Interesse::with(['empresa', 'classificacao'])->latest()->paginate(15);

        return view('painel.interesses.index', compact('interesses'));
    }

    public function create()
    {
        return view('painel.interesses.form', $this->options());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['empresa_id'] = $data['empresa_id'] ?: Auth::user()->empresa_id;
        Interesse::create($data);

        return redirect()->route('interesses.index')->with('swal_success', 'Interesse cadastrado com sucesso!');
    }

    public function show(Interesse $interesse, MatchInteligenteService $matchService)
    {
        $residuos = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('status', 'disponivel')
            ->where('classificacao_id', $interesse->classificacao_id)
            ->where('tipo_material', 'like', '%' . $interesse->tipo_material . '%')
            ->get();

        return view('painel.interesses.visualizar', compact('interesse', 'residuos'));
    }

    public function edit(Interesse $interesse)
    {
        return view('painel.interesses.form', array_merge($this->options(), compact('interesse')));
    }

    public function update(Request $request, Interesse $interesse)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['empresa_id'] = $data['empresa_id'] ?: Auth::user()->empresa_id;
        $interesse->update($data);

        return redirect()->route('interesses.index')->with('swal_success', 'Interesse atualizado com sucesso!');
    }

    public function destroy(Interesse $interesse)
    {
        $interesse->delete();

        return redirect()->route('interesses.index')->with('swal_success', 'Interesse excluído com sucesso!');
    }

    private function options(): array
    {
        return [
            'empresas' => Empresa::orderBy('nome')->get(),
            'classificacoes' => ClassificacaoResiduo::orderBy('nome')->get(),
        ];
    }

    private function rules(): array
    {
        return [
            'empresa_id' => ['nullable', 'exists:empresas,id'],
            'tipo_material' => ['required', 'string', 'max:255'],
            'classificacao_id' => ['required', 'exists:classificacoes_residuo,id'],
            'quantidade_minima' => ['nullable', 'numeric', 'min:0'],
            'quantidade_maxima' => ['nullable', 'numeric', 'min:0'],
            'raio_km' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    private function messages(): array
    {
        return [
            'tipo_material.required' => 'O tipo de material é obrigatório.',
            'classificacao_id.required' => 'A classificação é obrigatória.',
            'classificacao_id.exists' => 'Informe uma classificação válida.',
            '*.numeric' => 'Informe apenas números nos campos quantitativos.',
            '*.min' => 'Os valores não podem ser negativos.',
        ];
    }
}
