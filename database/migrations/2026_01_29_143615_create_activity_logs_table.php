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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user', 255)->default('System');
            $table->string('action', 100)->nullable(); // create, update, delete, upload, download
            $table->string('module', 100)->nullable(); // perencanaan, monitoring, mekanisme, dokumentasi, dasar_hukum
            $table->string('description', 500)->nullable(); // Deskripsi aksi
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Indexing untuk performa query
            $table->index('action');
            $table->index('module');
            $table->index(['created_at', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
