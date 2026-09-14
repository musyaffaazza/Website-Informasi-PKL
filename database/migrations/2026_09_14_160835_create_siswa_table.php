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
        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->unique();

            $table->string('nis', 30)->unique();
            $table->string('nisn', 30)->unique();
            $table->string('nama', 100);

            $table->unsignedInteger('rombel_id');
            $table->unsignedInteger('jurusan_id');

            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();

            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();

            $table->string('nama_ortu', 100)->nullable();
            $table->string('kontak_darurat', 20)->nullable();

            $table->string('foto_url', 255)->nullable();

            $table->enum('status_akun', ['aktif', 'nonaktif'])
                ->default('aktif');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('rombel_id')
                ->references('id')
                ->on('rombel')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};