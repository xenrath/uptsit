<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perangkat_id');
            $table->foreign('perangkat_id')->references('id')->on('perangkats')->restrictOnDelete();
            $table->date('tanggal');
            $table->string('keterangan');
            $table->string('foto_sebelum');
            $table->string('foto_sesudah');
            $table->string('paraf');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perbaikans');
    }
};
