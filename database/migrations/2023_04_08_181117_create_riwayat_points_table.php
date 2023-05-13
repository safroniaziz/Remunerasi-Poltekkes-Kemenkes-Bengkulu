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
        Schema::create('riwayat_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rubrik_id');
            $table->unsignedBigInteger('periode_id');
            $table->string('nip',18)->unique();
            $table->string('point');
            $table->timestamps();

            $table->foreign('rubrik_id')->references('id')->on('rubriks');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('nip')->references('nip')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_points');
    }
};
