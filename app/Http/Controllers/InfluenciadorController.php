<?php

namespace App\Http\Controllers;

use App\Models\Influenciador;
use Illuminate\Http\Request;

class InfluenciadorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $influenciadores = $request->has('id') ? Influenciador::where('id', $request->id)->first() : Influenciador::paginate(10);
            if ($influenciadores->isEmpty()) {
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
    }

}
