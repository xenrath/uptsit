<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('lokasi');
            $table->string('unit');
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->restrictOnDelete();
            $table->unsignedBigInteger('spek_barang_jenis_id');
            $table->foreign('spek_barang_jenis_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->unsignedBigInteger('spek_barang_merek_id');
            $table->foreign('spek_barang_merek_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->string('no_seri');
            $table->unsignedBigInteger('spek_barang_model_id');
            $table->foreign('spek_barang_model_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->unsignedBigInteger('spek_storage_tipe_id');
            $table->foreign('spek_storage_tipe_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->string('storage_kapasitas');
            $table->unsignedBigInteger('spek_storage_merek_id');
            $table->foreign('spek_storage_merek_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->unsignedBigInteger('spek_ram_tipe_id');
            $table->foreign('spek_ram_tipe_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->unsignedBigInteger('spek_ram_merek_id');
            $table->foreign('spek_ram_merek_id')->references('id')->on('spek_barangs')->restrictOnDelete();
            $table->string('ram_kapasitas');
            $table->string('psu_merek');
            $table->string('psu_kapasitas');
            $table->string('heatsink_merek');
            $table->string('heatsink_model');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkats');
    }
};
