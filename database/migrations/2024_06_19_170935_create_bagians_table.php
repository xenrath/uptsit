<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bagians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->restrictOnDelete();
            $table->string('sebagai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bagians');
    }
};
