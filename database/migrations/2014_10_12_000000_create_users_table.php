<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('telp')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('foto')->nullable();
            $table->enum('bagian', ['admin', 'programmer', 'jaringan', 'support']);
            $table->boolean('is_cbt')->default(false);
            $table->enum('role', ['admin', 'user']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
