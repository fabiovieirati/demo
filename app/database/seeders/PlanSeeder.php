<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\Utils\Json;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = Json::decode(Storage::disk('local')->get('/jsons/plans.json'));

        foreach ($plans as $plan) {
            Plan::create([
                'registro' =>   $plan->registro,
                'nome' =>       Str::lower($plan->nome), 
                'codigo' =>     $plan->codigo
            ]);
        }
    }
}
