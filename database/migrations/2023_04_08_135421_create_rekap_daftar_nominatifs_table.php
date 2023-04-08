<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_daftar_nominatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->string('nip',18)->unique();
            $table->string('nama');
            $table->string('slug');
            $table->string('nomor_rekening');
            $table->string('npwp');
            $table->string('jabatan_dt');
            $table->string('jabatan_ds');
            $table->string('golongan');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('total_point');
            $table->string('remun_P1');
            $table->string('remun_P2');
            $table->string('total_remun');
            $table->string('faktor_pengurang_pph');
            $table->string('remun_dibayarkan');
            $table->boolean('is_active');
            $table->timestamps();


            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('nip')->references('nip')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_daftar_nominatifs');
    }
};
