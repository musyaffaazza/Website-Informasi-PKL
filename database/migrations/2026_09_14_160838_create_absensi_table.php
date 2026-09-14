<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('siswa_id');

            $table->date('tanggal');

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alpa'
            ]);

            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->text('keterangan')->nullable();
            $table->string('bukti_url', 255)->nullable();

            $table->dateTime('dibuat_pada');

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique([
                'siswa_id',
                'tanggal'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};