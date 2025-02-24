<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Campanha;
use GuzzleHttp\Psr7\Response;

class CampanhasController extends Controller
{
    public function index(Request $request)
    {
        try {
            $campanha = Campanha::with('influenciadores')->paginate(10);
            if ($campanha->isEmpty()) {
                return response()->json(['message' => 'Nenhuma campanha encontrado', 'level' => false, 'request' => $request->all()], 404);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao processar a solicitação', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Dados capturados com sucesso', 'level' => true, 'data' => $campanha], 200);
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'orcamento' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'data_inicio' => 'required|string',
            'data_fim' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro ao se cadaastrar Campanha', 'level' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $create = [
                'nome' => $request->nome, 
                'orcamento' => $request->orcamento, 
                'descricao' => $request->descricao,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim
            ];
            
            $campanha = Campanha::create($create);
            
            return response()->json(['message' => 'Campanha cadastrada com sucesso', 'level' => true, 'data' => $campanha], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao processar a solicitação de cadastro', 
                'level' => false, 
                'request' => $request->all(), 
                'error' => $th->getMessage()
            ], 500);
        } 
    }
    
    public function mask(Request $request, $campanhaId)
    {
        $campanha = Campanha::findOrFail($campanhaId);
        $campanha->influenciadores()->sync($request->influenciador_ids);

        return response()->json(['message' => 'Influenciador(es) vinculados com sucesso!']);
    }
}
