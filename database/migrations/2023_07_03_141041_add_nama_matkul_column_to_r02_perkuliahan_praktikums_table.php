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
        Schema::table('r02_perkuliahan_praktikums', function (Blueprint $table) {
            $table->string('nama_matkul')->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('r02_perkuliahan_praktikums', function (Blueprint $table) {
            //
        });
    }
};
