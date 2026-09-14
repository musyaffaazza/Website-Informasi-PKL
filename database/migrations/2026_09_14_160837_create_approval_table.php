<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('pengajuan_id');
            $table->unsignedInteger('guru_id');

            $table->enum('tahap', [
                'walikelas',
                'kaprog',
                'hubinmas'
            ]);

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak'
            ])->default('menunggu');

            $table->text('catatan')->nullable();
            $table->dateTime('diproses_pada')->nullable();

            $table->foreign('pengajuan_id')
                ->references('id')
                ->on('pengajuan_pkl')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('guru_id')
                ->references('id')
                ->on('guru')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval');
    }
};