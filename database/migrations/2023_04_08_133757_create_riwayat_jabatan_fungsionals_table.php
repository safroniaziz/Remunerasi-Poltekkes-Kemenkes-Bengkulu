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
        Schema::create('riwayat_jabatan_fungsionals', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18);
            $table->unsignedBigInteger('jabatan_ds_id');
            $table->string('nama_jabatan_fungsional');
            $table->string('slug');
            $table->date('tmt_jabatan_fungsional');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('nip')->references('nip')->on('pegawais');
            $table->foreign('jabatan_ds_id')->references('id')->on('jabatan_ds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_fungsionals');
    }
};
