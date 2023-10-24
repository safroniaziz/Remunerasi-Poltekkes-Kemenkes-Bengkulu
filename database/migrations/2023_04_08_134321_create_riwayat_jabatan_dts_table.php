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
        Schema::create('riwayat_jabatan_dts', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18);
            $table->unsignedBigInteger('jabatan_dt_id');
            $table->string('nama_jabatan_dt');
            $table->string('slug');
            $table->string('tmt_jabatan_dt');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nip')->references('nip')->on('pegawais');
            $table->foreign('jabatan_dt_id')->references('id')->on('jabatan_dts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan_dts');
    }
};
