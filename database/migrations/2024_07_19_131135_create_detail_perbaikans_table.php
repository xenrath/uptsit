<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perbaikan_id');
            $table->foreign('perbaikan_id')->references('id')->on('perbaikans')->restrictOnDelete();
            $table->unsignedBigInteger('sparepart_id');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_perbaikans');
    }
};
