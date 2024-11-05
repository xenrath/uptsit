<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['motherboard', 'prosesor', 'ram', 'storage', 'psu', 'heatsink', 'monitor', 'keyboard', 'mouse']);
            $table->string('merek')->nullable();
            $table->string('model')->nullable();
            $table->string('tipe')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('jumlah');
            $table->boolean('is_baru')->default(false);
            $table->string('tanggal')->nullable();
            $table->string('garansi')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('bukti')->nullable();
            $table->string('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spareparts');
    }
};
