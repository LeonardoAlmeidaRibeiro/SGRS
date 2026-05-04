<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function edit()
    {
        $usuario = Auth::user();

        return view('painel.perfil.index', compact('usuario'));
    }

    public function updateDadosPessoais(Request $request)
    {
        $usuario = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'telefone' => ['nullable', 'string', 'max:20'],
            'cpf' => ['nullable', 'string', 'max:14', Rule::unique('users', 'cpf')->ignore($usuario->id)],
            'data_nascimento' => ['nullable', 'date'],
        ], $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'dadosPessoais')
                ->withInput()
                ->with('perfil_tab', 'dados');
        }

        $usuario->update($validator->validated());

        return back()
            ->with('success_dados', 'Dados pessoais atualizados com sucesso!')
            ->with('perfil_tab', 'dados');
    }

    public function updateEndereco(Request $request)
    {
        $usuario = Auth::user();

        $validator = Validator::make($request->all(), [
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'size:2'],
        ], $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'endereco')
                ->withInput()
                ->with('perfil_tab', 'endereco');
        }

        $usuario->update($validator->validated());

        return back()
            ->with('success_endereco', 'Endereço pessoal atualizado com sucesso!')
            ->with('perfil_tab', 'endereco');
    }

    public function updateEmpresaLegal(Request $request)
    {
        $empresa = optional(Auth::user())->empresa;

        if (!$empresa) {
            return back()
                ->with('swal_error', 'Seu usuario nao esta vinculado a uma empresa.')
                ->with('perfil_tab', 'empresa');
        }

        $validator = Validator::make($request->all(), [
            'possui_licenca_ambiental' => ['nullable', 'boolean'],
            'licenca_residuos_perigosos' => ['nullable', 'boolean'],
            'numero_licenca_ambiental' => ['nullable', 'string', 'max:100'],
            'validade_licenca_ambiental' => ['nullable', 'date'],
            'licenca_ambiental_arquivo' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'empresaLegal')
                ->withInput()
                ->with('perfil_tab', 'empresa');
        }

        $dados = $validator->validated();
        unset($dados['licenca_ambiental_arquivo']);
        $dados['possui_licenca_ambiental'] = $request->boolean('possui_licenca_ambiental');
        $dados['licenca_residuos_perigosos'] = $request->boolean('licenca_residuos_perigosos');

        if ($request->hasFile('licenca_ambiental_arquivo')) {
            $dados['licenca_ambiental_url'] = Storage::url($request->file('licenca_ambiental_arquivo')->store('licencas_empresas', 'public'));
        }

        $empresa->update($dados);

        return back()
            ->with('swal_success', 'Dados legais da empresa atualizados com sucesso!')
            ->with('perfil_tab', 'empresa');
    }

    private function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'telefone.max' => 'O telefone deve ter no máximo 20 caracteres.',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.date' => 'Informe uma data de nascimento válida.',
            'cep.max' => 'O CEP deve ter no máximo 9 caracteres.',
            'endereco.max' => 'O endereço deve ter no máximo 255 caracteres.',
            'numero.max' => 'O número deve ter no máximo 20 caracteres.',
            'complemento.max' => 'O complemento deve ter no máximo 100 caracteres.',
            'bairro.max' => 'O bairro deve ter no máximo 100 caracteres.',
            'cidade.max' => 'A cidade deve ter no máximo 100 caracteres.',
            'estado.size' => 'O estado deve ter 2 letras.',
            'numero_licenca_ambiental.max' => 'O numero da licenca deve ter no maximo 100 caracteres.',
            'validade_licenca_ambiental.date' => 'Informe uma validade de licenca valida.',
            'licenca_ambiental_arquivo.file' => 'Anexe uma licenca ambiental valida.',
            'licenca_ambiental_arquivo.mimes' => 'A licenca ambiental deve ser PDF, JPG ou PNG.',
            'licenca_ambiental_arquivo.max' => 'A licenca ambiental deve ter no maximo 5MB.',
        ];
    }
}
