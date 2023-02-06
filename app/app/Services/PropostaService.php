<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Str;

class PropostaService
{
    public function __construct( Plan $plan )
    {
        $this->plan = $plan;
    }

    public function calcularProposta($infoBeneficiarios, $plano)
    {
            
        foreach ($plano["prices"] as $key => $value) {
                
            if ($value["minimo_vidas"] <= $infoBeneficiarios["quantidadeBeneficiarios"]) {
                $price = $value;
            }
        }
        
        $valorTotal = 0;

        foreach ($infoBeneficiarios["beneficiarios"] as $key => $value) {
            
            if ($value["idade"] <= 17 && is_numeric($value["idade"])) {
                $infoBeneficiarios["beneficiarios"][$key]["preco"] = floatval($price["faixa1"]);
                $valorTotal += $price["faixa1"];
            }elseif ($value["idade"] <= 40 && is_numeric($value["idade"])) {
                $infoBeneficiarios["beneficiarios"][$key]["preco"] = floatval($price["faixa2"]);
                $valorTotal += $price["faixa2"];
            }elseif ($value["idade"] > 40 && is_numeric($value["idade"])) {
                $infoBeneficiarios["beneficiarios"][$key]["preco"] = floatval($price["faixa3"]);
                $valorTotal += $price["faixa3"];
            }
        }

        $infoBeneficiarios["valorToral"] = $valorTotal;

        return $infoBeneficiarios;
    }

    public function validarProposta( $infoBeneficiarios )
    {
        $planoEscolhido = Str::lower($infoBeneficiarios["planoEscolhido"]);

        $plano = $this->plan->where('nome', $planoEscolhido)
            ->get()->load('prices')->first();
        
        if (!$plano) {
            return null;
        }

        return $plano->toArray();
    }
}