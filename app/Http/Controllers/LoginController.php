<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function cadastro()
    {

        $estados = Estado::all();
        $cidades = Cidade::all();
        return view('cadastro', compact('estados', 'cidades'));
    }

    public function store(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:empresas,cnpj',
            'tipo_industria' => 'required',
            'telefone' => 'required',
            'email' => 'required|email|unique:empresas,email',

            'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'estado' => 'required',
            'cidade' => 'required',

            'admin_nome' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',

            'senha' => 'required|min:6|confirmed',

            'termos' => 'required|accepted',
        ], [
            'senha.confirmed' => 'As senhas não conferem',
            'termos.accepted' => 'Você precisa aceitar os termos',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // 1. Criar empresa
            $empresa = Empresa::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'tipo_industria' => $request->tipo_industria,
                'cnpj' => $request->cnpj,
                'telefone' => $request->telefone,
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // 2. Criar usuário admin
            $usuario = User::create([
                'empresa_id' => $empresa->id,
                'name' => $request->admin_nome,
                'email' => $request->admin_email,
                'password' => Hash::make($request->senha),
                'perfil' => 'admin',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Empresa cadastrada com sucesso!',
                'id' => $empresa->id
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar empresa',
                'error' => $e->getMessage() // pode remover em produção
            ], 500);
        }
    }

    public function access(Request $request)
    {
        // Validação
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Tentativa de login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->senha
        ])) {

            $request->session()->regenerate();

            return redirect()->route('painel.home');
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida sessão
        $request->session()->invalidate();

        // Regenera token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('painel.login');
    }
}
