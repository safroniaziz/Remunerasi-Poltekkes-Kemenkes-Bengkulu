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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->string('nama_user');
            $table->enum('level_jurusan',['gizi','kebidanan','keperawatan','analis_kesehatan','promosi_kesehatan','kesehatan_lingkungan']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('status');
            $table->boolean('is_active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
