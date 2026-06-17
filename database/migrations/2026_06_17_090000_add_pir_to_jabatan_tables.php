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
        Schema::table('jabatan_dts', function (Blueprint $table) {
            $table->string('pir')->default('2500')->after('gaji_blu');
        });

        Schema::table('jabatan_ds', function (Blueprint $table) {
            $table->string('pir')->default('2500')->after('gaji_blu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jabatan_dts', function (Blueprint $table) {
            $table->dropColumn('pir');
        });

        Schema::table('jabatan_ds', function (Blueprint $table) {
            $table->dropColumn('pir');
        });
    }
};
