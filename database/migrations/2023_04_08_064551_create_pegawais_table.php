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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('nip',18)->unique();
            $table->string('nidn');
            $table->string('nama');
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('jurusan');
            $table->string('nomor_rekening');
            $table->string('npwp');
            $table->enum('serdos',['0','1']);
            $table->string('no_sertifikat_serdos');
            $table->string('no_whatsapp');
            $table->boolean('is_active');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
