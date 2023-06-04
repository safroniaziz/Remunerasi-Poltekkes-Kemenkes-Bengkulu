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
            $table->string('nip')->reference('nip')->on('pegawais');
            $table->string('periode_id')->reference('id')->on('periodes');
            $table->double('total_point');
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
