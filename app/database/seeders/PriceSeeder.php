<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Json;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $prices = Json::decode(Storage::disk('local')->get('/jsons/prices.json'));

        foreach ($prices as $price) {
            Price::create([
                'codigo_id' =>      $price->codigo,
                'minimo_vidas' =>   $price->minimo_vidas,
                'faixa1' =>         $price->faixa1,
                'faixa2' =>         $price->faixa2,
                'faixa3' =>         $price->faixa3,
            ]);
        }
    }
}
