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
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('kota', 100)->nullable()->after('tanggal_lahir');
            $table->string('kampus', 50)->default('Kampus Pusat')->after('jurusan_id');
            $table->string('status_pkl', 50)->default('Siap Terjun')->after('status_akun');
            $table->string('status_akun', 30)->default('aktif')->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'kota',
                'kampus',
                'status_pkl',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
