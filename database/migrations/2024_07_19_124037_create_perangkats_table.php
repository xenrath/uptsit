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
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->restrictOnDelete();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->restrictOnDelete();
            $table->enum('jenis', ['pc', 'laptop']);
            $table->string('merek');
            $table->string('model');
            $table->string('no_seri')->unique();
            $table->string('ram_tipe');
            $table->string('ram_kapasitas');
            $table->string('ram_merek');
            $table->boolean('is_ram_tambahan')->default(false);
            $table->string('ram_tambahan_kapasitas')->nullable();
            $table->string('ram_tambahan_merek')->nullable();
            $table->enum('storage_tipe', ['HDD', 'SSD']);
            $table->string('storage_kapasitas');
            $table->string('storage_merek');
            $table->boolean('is_storage_tambahan')->default(false);
            $table->enum('storage_tambahan_tipe', ['HDD', 'SSD'])->nullable();
            $table->string('storage_tambahan_kapasitas')->nullable();
            $table->string('storage_tambahan_merek')->nullable();
            $table->string('psu_kapasitas')->nullable();
            $table->string('psu_merek')->nullable();
            $table->string('heatsink_model')->nullable();
            $table->string('heatsink_merek')->nullable();
            $table->string('monitor_ukuran')->nullable();
            $table->string('monitor_merek')->nullable();
            $table->string('keyboard_merek')->nullable();
            $table->string('mouse_merek')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkats');
    }
};
