<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembimbing_penugasan', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('siswa_id');
            $table->unsignedInteger('pengajuan_id');
            $table->unsignedInteger('pembimbing_guru_id');

            $table->date('tanggal_mulai');

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pengajuan_id')
                ->references('id')
                ->on('pengajuan_pkl')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pembimbing_guru_id')
                ->references('id')
                ->on('guru')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique([
                'siswa_id',
                'pengajuan_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing_penugasan');
    }
};