<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoFinanciamientoPlazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_financiamiento_plazo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_financiamiento_id');
            $table->smallInteger('plazo');
            $table->float('cuota_entrada')->default(0.0);
            $table->float('cuota_final')->default(0.0);

            $table->foreign('tipo_financiamiento_id')
                ->references('id')
                ->on('tipo_financiamiento')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_financiamiento_plazo');
    }
}
