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
            $table->string('slug');
            $table->string('email')->unique();
            $table->enum('jenis_kelamin',['L','P']);
            $table->enum('jurusan',['gizi','kebidanan','keperawatan','analis_kesehatan','promosi_kesehatan','kesehatan_lingkungan']);
            $table->string('nomor_rekening');
            $table->string('npwp');
            $table->boolean('is_serdos');
            $table->string('no_sertifikat_serdos')->nullable();
            $table->string('no_whatsapp');
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
