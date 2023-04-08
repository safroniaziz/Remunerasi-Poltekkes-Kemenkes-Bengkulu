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
        Schema::create('nilai__ewmps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_rubrik_id');
            $table->string('nama_rubrik');
            $table->string('nama_tabel_rubrik');
            $table->float('ewmp');
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('kelompok_rubrik_id')->references('id')->on('kelompok_rubriks');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai__ewmps');
    }
};
