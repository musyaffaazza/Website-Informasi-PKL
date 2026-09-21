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
        Schema::table('industri', function (Blueprint $table) {
            $table->string('bidang_usaha', 150)->nullable()->after('nama');
            $table->string('no_mou', 100)->nullable()->after('alamat');
            $table->integer('kuota_terisi')->default(0)->after('kuota');
            $table->string('wilayah', 100)->default('Bogor')->after('alamat');
            $table->string('kontak_jabatan', 100)->nullable()->after('kontak_nama');
            $table->string('pembimbing_nama', 150)->nullable()->after('kontak_email');
            $table->unsignedInteger('pembimbing_guru_id')->nullable()->after('pembimbing_nama');
            $table->string('status_kemitraan', 30)->default('aktif')->after('status');
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industri', function (Blueprint $table) {
            $table->dropColumn([
                'bidang_usaha',
                'no_mou',
                'kuota_terisi',
                'wilayah',
                'kontak_jabatan',
                'pembimbing_nama',
                'pembimbing_guru_id',
                'status_kemitraan',
            ]);
        });
    }
};
