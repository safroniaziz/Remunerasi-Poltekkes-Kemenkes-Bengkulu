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
        Schema::create('jabatan_ds', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan_ds');
            $table->string('slug');
            $table->string('grade');
            $table->string('harga_point_ds');
            $table->string('gaji_blu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_ds');
    }
};
