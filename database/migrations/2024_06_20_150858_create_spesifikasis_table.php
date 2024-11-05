<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spesifikasis', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['motherboard', 'prosesor', 'ram', 'storage']);
            $table->enum('grup', ['merek', 'model', 'tipe', 'kapasitas']);
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spesifikasis');
    }
};
