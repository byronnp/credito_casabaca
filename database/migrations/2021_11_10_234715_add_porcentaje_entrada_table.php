<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPorcentajeEntradaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_financiamiento_plazo', function (Blueprint $table) {
            $table->float('porcentaje_entrada', 8, 2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_financiamiento_plazo', function (Blueprint $table) {
            $table->dropColumn('porcentaje_entrada');
        });
    }
}
