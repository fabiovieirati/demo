<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('codigo_id')->constrained('plans', 'codigo');
            $table->unsignedInteger('minimo_vidas');
            $table->unsignedFloat('faixa1');
            $table->unsignedFloat('faixa2');
            $table->unsignedFloat('faixa3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
