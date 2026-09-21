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
        Schema::table('guru', function (Blueprint $table) {
            $table->string('nuptk', 50)->nullable()->after('nip');
            $table->string('jenis_kelamin', 20)->default('Laki-laki')->after('nama');
            $table->string('pendidikan', 100)->nullable()->after('jenis_kelamin');
            $table->string('avatar_url', 255)->nullable()->after('pendidikan');
            $table->json('roles_list')->nullable()->after('status_akun');
            $table->string('kelas_diampu', 255)->nullable()->after('roles_list');
            $table->string('keterangan_diampu', 255)->nullable()->after('kelas_diampu');
            $table->unsignedInteger('jurusan_id')->nullable()->after('keterangan_diampu');
            $table->string('status_akun', 30)->default('aktif')->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn([
                'nuptk',
                'jenis_kelamin',
                'pendidikan',
                'avatar_url',
                'roles_list',
                'kelas_diampu',
                'keterangan_diampu',
                'jurusan_id',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
