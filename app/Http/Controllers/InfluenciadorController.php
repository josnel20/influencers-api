<?php

namespace App\Http\Controllers;

use App\Models\Influenciador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfluenciadorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $influenciadores = $request->has('id') ? Influenciador::where('id', $request->id)->first() : Influenciador::paginate(10);
            if (! $influenciadores) {
                return response()->json(['message' => 'Nenhum influenciador encontrado', 'level' => false, 'request' => $request->all()], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao processar a solicitação', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Dados capturados com sucesso', 'level' => true, 'data' => $influenciadores], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'usuario_instagram' => 'required|string|unique:influenciadors,usuario_instagram',
            'quantidade_seguidores' => 'required|integer',
            'categoria' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro ao se cadaastrar', 'level' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $upsert = [
                'nome' => $request->nome, 
                'usuario_instagram' => $request->usuario_instagram, 
                'quantidade_seguidores' => $request->quantidade_seguidores,
                'categoria' => $request->categoria
            ];
            
            Influenciador::upsert([$upsert] ?? [], ['usuario_instagram'], ['nome', 'quantidade_seguidores', 'categoria']);
           
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao processar a solicitação de cadastro', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Influenciador cadastrado com sucesso!', 'level' => true], 201);
    }

}
