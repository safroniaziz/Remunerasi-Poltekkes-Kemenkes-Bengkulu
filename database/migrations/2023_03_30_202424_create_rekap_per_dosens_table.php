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
        Schema::create('rekap_per_dosens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nip')->reference('id')->on('pegawais');
            $table->unsignedBigInteger('periode_id')->reference('id')->on('periodes');
            $table->double('total_point_dosen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_per_dosens');
    }
};
