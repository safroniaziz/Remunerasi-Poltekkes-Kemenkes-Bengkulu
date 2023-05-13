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
        Schema::create('pangkat_golongans', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18);
            $table->string('nama_pangkat');
            $table->string('slug');
            $table->string('golongan');
            $table->string('tmt_pangkat_golongan');
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
        Schema::dropIfExists('pangkat_golongans');
    }
};
