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
        Schema::create('t_admin', function (Blueprint $table) {
            $table->string('id_admin', 20)->primary();
            $table->string('nama_admin', 50);
            $table->string('username_admin', 20)->unique();
            $table->string('password_admin');
            $table->enum('is_delete_admin', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_admin');
    }
};
