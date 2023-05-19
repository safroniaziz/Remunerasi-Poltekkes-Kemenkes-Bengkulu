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
        Schema::create('r019_latih_nyuluh_natar_ceramah_wargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->string('nip',18);
            $table->string('judul_kegiatan');
            $table->string('jenis');
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
        Schema::dropIfExists('r019_beri_latih_nyuluh_penatar_ceramah_masyarakats');
    }
};
