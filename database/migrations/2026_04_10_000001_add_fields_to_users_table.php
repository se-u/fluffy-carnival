<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('pasien')->after('password');
            $table->string('alamat', 255)->nullable()->after('role');
            $table->string('no_ktp', 20)->nullable()->after('alamat');
            $table->string('no_hp', 20)->nullable()->after('no_ktp');
            $table->string('no_rm', 20)->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'alamat', 'no_ktp', 'no_hp', 'no_rm']);
        });
    }
};
