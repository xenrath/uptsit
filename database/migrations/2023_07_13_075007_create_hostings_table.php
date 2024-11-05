<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hostings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('kategori');
            $table->string('nama_instansi');
            $table->string('nama_kepala');
            $table->string('nipy_kepala');
            $table->string('jabatan_kepala');
            $table->string('nama_admin_1');
            $table->string('nipy_admin_1');
            $table->string('jabatan_admin_1');
            $table->string('email_admin_1');
            $table->string('telp_admin_1');
            $table->string('nama_admin_2');
            $table->string('nipy_admin_2');
            $table->string('jabatan_admin_2');
            $table->string('email_admin_2');
            $table->string('telp_admin_2');
            $table->string('deskripsi');
            $table->string('sub_domain');
            $table->string('ip_address')->nullable();
            $table->string('ftp')->nullable();
            $table->string('tanggal_awal');
            $table->string('tanggal_akhir')->nullable();
            $table->enum('status', ['menunggu', 'proses', 'selesai']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hostings');
    }
};
