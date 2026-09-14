<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->string('aksi', 100);
            $table->string('modul', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->dateTime('dibuat_pada');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};