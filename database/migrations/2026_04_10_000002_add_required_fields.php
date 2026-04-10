<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add stok to obat table
        Schema::table('obat', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('harga');
        });

        // Add status to daftar_poli table
        Schema::table('daftar_poli', function (Blueprint $table) {
            $table->enum('status', ['pending', 'periksa', 'selesai', 'bayar', 'lunas'])
                  ->default('pending')
                  ->after('no_antrian');
        });

        // Add bukti_bayar to periksa table
        Schema::table('periksa', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->after('biaya_periksa');
        });

        // Add no_antrian_sekarang to jadwal_periksa table
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->integer('no_antrian_sekarang')->default(0)->after('jam_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn('stok');
        });

        Schema::table('daftar_poli', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('periksa', function (Blueprint $table) {
            $table->dropColumn('bukti_bayar');
        });

        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->dropColumn('no_antrian_sekarang');
        });
    }
};
