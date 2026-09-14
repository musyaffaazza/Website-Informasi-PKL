<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('siswa_id');
            $table->unsignedInteger('guru_id')->nullable();

            $table->date('tanggal');
            $table->string('kegiatan', 255);
            $table->text('deskripsi')->nullable();
            $table->text('hasil')->nullable();
            $table->text('kendala')->nullable();
            $table->text('solusi')->nullable();
            $table->string('bukti_url', 255)->nullable();

            $table->enum('status', [
                'draft',
                'diajukan',
                'disetujui',
                'ditolak'
            ])->default('draft');

            $table->dateTime('dibuat_pada');

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('guru_id')
                ->references('id')
                ->on('guru')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->unique(['siswa_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};