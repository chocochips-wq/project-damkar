<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Folder Perencanaan
        Schema::create('folder_perencanaan', function (Blueprint $table) {
            $table->string('id_folder_per', 50)->primary();
            $table->string('id_parent', 50)->nullable();
            $table->string('nama_folder_per', 191);
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 2. Tbl Perencanaan
        Schema::create('tbl_perencanaan', function (Blueprint $table) {
            $table->string('id_perencanaan', 50)->primary();
            $table->string('id_folder_per', 50)->nullable();
            $table->string('nama_file', 191);
            $table->string('file_path', 191)->nullable();
            $table->string('link', 191)->nullable();
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 3. Folder Monitoring
        Schema::create('folder_monitoring', function (Blueprint $table) {
            $table->string('id_folder_mon', 50)->primary();
            $table->string('id_parent', 50)->nullable();
            $table->string('nama_folder_mon', 191);
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 4. Tbl Monitoring Pelaporan
        Schema::create('tbl_monitoring_pelaporan', function (Blueprint $table) {
            $table->string('id_monitoring', 50)->primary();
            $table->string('id_folder_mon', 50)->nullable();
            $table->string('nama_file', 191);
            $table->string('file_path', 191)->nullable();
            $table->string('link', 191)->nullable();
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 5. Folder Mekanisme
        Schema::create('folder_mekanisme', function (Blueprint $table) {
            $table->string('id_folder_mek', 50)->primary();
            $table->string('id_parent', 50)->nullable();
            $table->string('nama_folder_mek', 191);
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 6. Tbl Mekanisme
        Schema::create('tbl_mekanisme', function (Blueprint $table) {
            $table->string('id_mekanisme', 50)->primary();
            $table->string('id_folder_mek', 50)->nullable();
            $table->string('nama_file', 191);
            $table->string('file_path', 191)->nullable();
            $table->string('link', 191)->nullable();
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 7. Tbl Dokumentasi
        Schema::create('tbl_dokumentasi', function (Blueprint $table) {
            $table->string('id_kegiatan', 50)->primary();
            $table->string('nama_kegiatan', 191);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('thumbnail', 191)->nullable();
            $table->string('ekstensi', 50)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 8. Tbl Dokumentasi File
        Schema::create('tbl_dokumentasi_file', function (Blueprint $table) {
            $table->string('id_file', 50)->primary();
            $table->string('id_kegiatan', 50)->nullable();
            $table->string('file_url', 191)->nullable();
            $table->string('ekstensi', 50)->nullable();
            $table->dateTime('created')->useCurrent();
        });

        // 9. Tbl Dasar Hukum
        Schema::create('tbl_dasar_hukum', function (Blueprint $table) {
            $table->string('id_hukum', 50)->primary();
            $table->string('nama_hukum', 191);
            $table->string('pemilik', 191)->nullable();
            $table->dateTime('created')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_dasar_hukum');
        Schema::dropIfExists('tbl_dokumentasi_file');
        Schema::dropIfExists('tbl_dokumentasi');
        Schema::dropIfExists('tbl_mekanisme');
        Schema::dropIfExists('folder_mekanisme');
        Schema::dropIfExists('tbl_monitoring_pelaporan');
        Schema::dropIfExists('folder_monitoring');
        Schema::dropIfExists('tbl_perencanaan');
        Schema::dropIfExists('folder_perencanaan');
    }
};
