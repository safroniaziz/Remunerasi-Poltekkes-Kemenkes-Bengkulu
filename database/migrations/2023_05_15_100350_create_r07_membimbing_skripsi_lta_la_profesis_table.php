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
        Schema::create('r07_membimbing_skripsi_lta_la_profesis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->string('nip',18);
            $table->integer('jumlah_mahasiswa');
            $table->string('pembimbing_ke');
            $table->boolean('is_bkd');
            $table->boolean('is_verified');
            $table->double('point')->nullable();
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
        Schema::dropIfExists('r07_membimbing_skripsi_lta_la_profesis');
    }
};
