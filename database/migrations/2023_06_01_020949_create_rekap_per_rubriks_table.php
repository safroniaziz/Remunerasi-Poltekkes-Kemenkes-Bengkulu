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
        Schema::create('rekap_per_rubriks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->string('kode_rubrik');
            $table->string('nama_rubrik');
            $table->integer('jumlah_data_seluruh');
            $table->double('jumlah_point_seluruh');
            $table->integer('jumlah_data_terhitung');
            $table->integer('jumlah_data_tidak_terhitung');
            $table->double('jumlah_point_tidak_terhitung');
            $table->double('total_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_per_rubriks');
    }
};
