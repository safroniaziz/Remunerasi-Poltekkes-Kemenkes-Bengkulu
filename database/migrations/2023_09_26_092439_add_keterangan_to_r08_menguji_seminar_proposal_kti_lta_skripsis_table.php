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
        Schema::table('r08_menguji_seminar_proposal_kti_lta_skripsis', function (Blueprint $table) {
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('r08_menguji_seminar_proposal_kti_lta_skripsis', function (Blueprint $table) {
            //
        });
    }
};
