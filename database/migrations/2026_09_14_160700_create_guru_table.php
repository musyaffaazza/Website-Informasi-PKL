<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->unique();
            $table->string('nip', 30)->unique();
            $table->string('nama', 100);
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('ttd_elektronik_url', 255)->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};