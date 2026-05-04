<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Support\EmpresaScope;

class EmpresaController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $empresas = Empresa::withCount(['usuarios', 'residuos'])
            ->when($this->empresaLogadaId(), function ($q) {
                $q->where('id', $this->empresaLogadaId());
            })
            ->orderBy('nome')
            ->paginate(15);

        return view('painel.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('painel.empresas.form', $this->options());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $empresa = Empresa::create($this->data($request, $validator->validated()));

        return redirect()
            ->route('empresas.show', $empresa->id)
            ->with('swal_success', 'Empresa cadastrada com sucesso!');
    }

    public function show(Empresa $empresa)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        $empresa->load(['usuarios', 'residuos.classificacao', 'avaliacoesRecebidas']);

        return view('painel.empresas.visualizar', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        return view('painel.empresas.form', array_merge($this->options(), compact('empresa')));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        $validator = Validator::make($request->all(), $this->rules($empresa->id), $this->messages());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $empresa->update($this->data($request, $validator->validated(), $empresa));

        return redirect()
            ->route('empresas.show', $empresa->id)
            ->with('swal_success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Empresa $empresa)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        if ($empresa->residuos()->exists() || $empresa->usuarios()->exists()) {
            return back()->with('swal_error', 'Nao e possivel excluir empresa com residuos ou funcionarios vinculados.');
        }

        $empresa->delete();

        return redirect()
            ->route('empresas.index')
            ->with('swal_success', 'Empresa excluida com sucesso!');
    }

    public function storeFuncionario(Request $request, Empresa $empresa)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'perfil' => ['required', 'in:admin,operador,comprador,auditor'],
            'password' => ['required', 'string', 'min:6'],
        ], $this->messages());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $validator->validated();
        $dados['empresa_id'] = $empresa->id;
        $dados['password'] = Hash::make($dados['password']);

        User::create($dados);

        return back()->with('swal_success', 'Funcionario cadastrado com sucesso!');
    }

    public function destroyFuncionario(Empresa $empresa, User $usuario)
    {
        $this->abortarSeNaoForEmpresa($empresa->id);

        if ((int) $usuario->empresa_id !== (int) $empresa->id) {
            return back()->with('swal_error', 'Funcionario nao pertence a esta empresa.');
        }

        $usuario->delete();

        return back()->with('swal_success', 'Funcionario removido com sucesso!');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('empresas', 'email')->ignore($ignoreId)],
            'tipo_industria' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:20', Rule::unique('empresas', 'cnpj')->ignore($ignoreId)],
            'telefone' => ['required', 'string', 'max:20'],
            'cep' => ['required', 'string', 'max:9'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'size:2'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'possui_licenca_ambiental' => ['nullable', 'boolean'],
            'licenca_residuos_perigosos' => ['nullable', 'boolean'],
            'numero_licenca_ambiental' => ['nullable', 'string', 'max:100'],
            'validade_licenca_ambiental' => ['nullable', 'date'],
            'licenca_ambiental_arquivo' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    private function data(Request $request, array $validated, ?Empresa $empresa = null): array
    {
        unset($validated['licenca_ambiental_arquivo']);
        $validated['estado'] = strtoupper($validated['estado']);
        $validated['possui_licenca_ambiental'] = $request->boolean('possui_licenca_ambiental');
        $validated['licenca_residuos_perigosos'] = $request->boolean('licenca_residuos_perigosos');

        if ($request->hasFile('licenca_ambiental_arquivo')) {
            $validated['licenca_ambiental_url'] = Storage::url($request->file('licenca_ambiental_arquivo')->store('licencas_empresas', 'public'));
        } elseif ($empresa) {
            $validated['licenca_ambiental_url'] = $empresa->licenca_ambiental_url;
        }

        return $validated;
    }

    private function options(): array
    {
        return [
            'perfis' => [
                'admin' => 'Administrador',
                'operador' => 'Operador',
                'comprador' => 'Comprador',
                'auditor' => 'Auditor',
            ],
        ];
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatorios.',
            '*.unique' => 'Este valor ja esta cadastrado.',
            '*.email' => 'Informe um e-mail valido.',
            '*.date' => 'Informe uma data valida.',
            '*.numeric' => 'Informe um numero valido.',
            'estado.size' => 'O estado deve ter 2 letras.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'licenca_ambiental_arquivo.mimes' => 'A licenca deve ser PDF, JPG ou PNG.',
            'licenca_ambiental_arquivo.max' => 'A licenca deve ter no maximo 5MB.',
        ];
    }
}
