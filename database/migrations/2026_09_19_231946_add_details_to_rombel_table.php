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
        Schema::table('rombel', function (Blueprint $table) {
            $table->string('kode_rombel', 50)->nullable()->after('id');
            $table->string('nama_rombel', 100)->nullable()->after('nama_kode');
            $table->string('tingkat', 10)->default('XII')->after('nama_rombel');
            $table->string('ruang', 100)->nullable()->after('tingkat');
            $table->integer('jumlah_siswa')->default(36)->after('wali_kelas_guru_id');
            $table->integer('siswa_terdata')->default(36)->after('jumlah_siswa');
            $table->string('status_pkl', 50)->default('Siap Terjun PKL')->after('siswa_terdata');
            $table->string('semester', 30)->default('Semester Ganjil')->after('tahun_ajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rombel', function (Blueprint $table) {
            $table->dropColumn([
                'kode_rombel',
                'nama_rombel',
                'tingkat',
                'ruang',
                'jumlah_siswa',
                'siswa_terdata',
                'status_pkl',
                'semester',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
