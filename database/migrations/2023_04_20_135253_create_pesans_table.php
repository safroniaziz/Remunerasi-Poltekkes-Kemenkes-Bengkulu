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
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18);
            $table->unsignedBigInteger('user_tujuan_id');
            $table->unsignedBigInteger('rubrik_id');
            $table->string('subjek');
            $table->text('content');
            $table->boolean('is_read');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('nip')->references('nip')->on('pegawais');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
