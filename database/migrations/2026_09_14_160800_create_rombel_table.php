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
        Schema::create('rombel', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nama_kode', 50);

            $table->unsignedInteger('jurusan_id');

            $table->unsignedInteger('wali_kelas_guru_id')->nullable();

            $table->string('tahun_ajaran', 9);

            $table->enum('status', ['aktif', 'nonaktif'])
                ->default('aktif');

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique([
                'jurusan_id',
                'nama_kode',
                'tahun_ajaran'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel');
    }
};