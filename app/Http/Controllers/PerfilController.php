<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ];
    }
}
