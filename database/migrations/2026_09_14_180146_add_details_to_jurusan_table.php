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
        Schema::table('jurusan', function (Blueprint $table) {
            $table->string('bidang', 100)->nullable()->after('nama');
            $table->string('akreditasi', 50)->default('A UNGGUL')->after('status');
            $table->integer('kuota_industri')->default(0)->after('akreditasi');
            $table->integer('kuota_terisi')->default(0)->after('kuota_industri');
            $table->string('badge_color', 30)->default('blue')->after('kuota_terisi');
            $table->json('mitra_utama')->nullable()->after('badge_color');
            $table->text('capaian_kurikulum')->nullable()->after('mitra_utama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->dropColumn([
                'bidang',
                'akreditasi',
                'kuota_industri',
                'kuota_terisi',
                'badge_color',
                'mitra_utama',
                'capaian_kurikulum',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
