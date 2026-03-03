<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_prediksi', function (Blueprint $table) {
            $table->string('id_prediksi', 10)->primary();
            $table->string('data_uji_id', 10);
            $table->float('akurasi')->nullable();
            $table->float('presisi')->nullable();
            $table->float('recall')->nullable();
            $table->float('f1_score')->nullable();
            $table->timestamps();

            $table->foreign('data_uji_id')->references('id_uji')->on('data_uji');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_prediksi');
    }
};
