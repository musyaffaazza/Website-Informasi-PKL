<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('siswa_id');
            $table->unsignedInteger('pengajuan_id');
            $table->unsignedInteger('guru_id');

            $table->decimal('nilai_pembimbing', 5, 2)->nullable();
            $table->decimal('nilai_industri', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();

            $table->text('catatan')->nullable();

            $table->dateTime('dinilai_pada')->nullable();

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

            $table->foreign('guru_id')
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
        Schema::dropIfExists('penilaian');
    }
};