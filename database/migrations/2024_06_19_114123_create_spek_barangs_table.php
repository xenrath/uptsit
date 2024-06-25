<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spek_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['jenis', 'merek', 'model']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spek_barangs');
    }
};
