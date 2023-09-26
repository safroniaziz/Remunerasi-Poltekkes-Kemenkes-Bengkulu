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
        Schema::table('r017_naskah_buku_bahasa_terbit_edar_nas', function (Blueprint $table) {
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('r017_naskah_buku_bahasa_terbit_edar_nas', function (Blueprint $table) {
            //
        });
    }
};
