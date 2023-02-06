<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropostaRequest;
use App\Services\PropostaService;
use Illuminate\Support\Facades\Storage;

class PropostaController extends Controller
{
    public function __construct(PropostaService $propostaService)
    {
        $this->propostaService = $propostaService;
    }

    public function store(StorePropostaRequest $request)
    {
        $now = time();

        Storage::disk('local')->put(
            "/jsons/beneficiarios$now.json",
            json_encode($request->toArray())
        );

        $plano = $this->propostaService
            ->validarProposta($request);
        
        if (!$plano) {

            return response()->json([
                'error' => true,
                'data' => $plano,
                'message' => 'Plano informado inexistente.'
            ]);
        }

        $proposta = $this->propostaService
            ->calcularProposta($request->toArray(), $plano); 
        
        Storage::disk('local')->put(
            "/jsons/proposta$now.json",
            json_encode($proposta)
        );

        return response()->json([
            'error' => false,
            'data' => $proposta
        ]);
    }
}
