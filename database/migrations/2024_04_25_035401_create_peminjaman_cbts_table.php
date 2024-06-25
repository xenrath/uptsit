<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman_cbts', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('keperluan', ['pembelajaran', 'lainnya']);
            $table->string('nama');
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->foreign('prodi_id')->references('id')->on('prodis')->restrictOnDelete();
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('jam_awal');
            $table->string('jam_akhir');
            $table->json('items')->nullable();
            $table->json('jumlahs')->nullable();
            $table->text('keterangan');
            $table->string('pj');
            $table->string('telp')->nullable();
            $table->string('ttd')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_cbts');
    }
};
