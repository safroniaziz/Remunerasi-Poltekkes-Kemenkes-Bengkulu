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
            $table->string('id_prodi_homebase')->nullable();
            $table->string('nidn');
            $table->string('nama');
            $table->string('slug');
            $table->string('email')->unique()->nullable();
            $table->enum('jenis_kelamin',['L','P'])->nullable();
            $table->string('jurusan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('npwp')->nullable();
            $table->boolean('is_serdos')->nullable();
            $table->string('no_sertifikat_serdos')->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
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
