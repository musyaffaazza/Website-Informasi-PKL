<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_pkl', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('siswa_id');
            $table->unsignedInteger('industri_id');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->string('dokumen_url', 255)->nullable();

            $table->enum('status', [
                'draft',
                'menunggu_walikelas',
                'menunggu_kaprog',
                'menunggu_hubinmas',
                'disetujui',
                'ditolak'
            ])->default('draft');

            $table->dateTime('dibuat_pada');

            $table->timestamps();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('industri_id')
                ->references('id')
                ->on('industri')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pkl');
    }
};