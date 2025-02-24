<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro ao se cadaastrar', 'level' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $upsert = [
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => Hash::make($request->password)
            ];
            
            User::upsert([$upsert] ?? [], ['email'], ['name', 'password']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao processar a solicitação de cadastro', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Usuário registrado com sucesso!', 'level' => true, 'users' => User::all()], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro no login', 'level' => false, 'errors' => $validator->errors()], 422);
        }

        try {

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado email incorreto'], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Credenciais inválidas, senha incorreta'], 401);
            }

            $token = JWTAuth::fromUser($user);

            return response()->json(['message' => 'sucesso: utilize o token para acessar os demais endpoints', 'level' => true, 'token' => $token]);

        } catch (JWTException $th) {
            return response()->json([
                'message' => 'Não foi possível criar o token', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
