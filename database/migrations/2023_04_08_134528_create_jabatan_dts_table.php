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
        Schema::create('jabatan_dts', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18)->unique();
            $table->string('nama_jabatan_dt');
            $table->string('slug');
            $table->string('grade');
            $table->string('harga_point_dt');
            $table->string('job_value');
            $table->string('pir');
            $table->string('harga_jabatan');
            $table->string('gaji_blu');
            $table->string('insentif_maximum');
            $table->boolean('is_active');
            $table->timestamps();


            $table->foreign('nip')->references('nip')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_dts');
    }
};
