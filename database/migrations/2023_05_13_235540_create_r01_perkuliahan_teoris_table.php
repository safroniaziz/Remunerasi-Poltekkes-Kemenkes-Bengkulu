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
        Schema::create('r01_perkuliahan_teoris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->string('nip',18);
            $table->string('nama_matkul');
            $table->string('kode_kelas');
            $table->integer('jumlah_sks');
            $table->integer('jumlah_mahasiswa');
            $table->integer('jumlah_tatap_muka')->nullable();
            $table->string('id_prodi')->nullable();
            $table->boolean('is_bkd');
            $table->boolean('is_verified');
            $table->enum('sumber_data',['siakad','manual']);
            $table->double('point')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('nip')->references('nip')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r01_perkuliahan_teoris');
    }
};
