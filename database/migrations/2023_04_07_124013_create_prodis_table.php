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
        Schema::create('prodis', function (Blueprint $table) {
            $table->string('id_prodi')->primary();
            $table->unsignedBigInteger('verifikator_id')->nullable();
            $table->unsignedBigInteger('penanggung_jawab_id')->nullable();
            $table->string('kdjen');
            $table->string('kdpst');
            $table->string('nama_jenjang');
            $table->string('nama_prodi');
            $table->string('nama_lengkap_prodi');
            $table->string('kodefak');
            $table->string('nmfak');
            $table->timestamps();

            $table->foreign('verifikator_id')->references('id')->on('users');
            $table->foreign('penanggung_jawab_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
