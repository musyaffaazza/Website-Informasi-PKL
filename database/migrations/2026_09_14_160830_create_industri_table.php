<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industri', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nama', 150);
            $table->text('alamat');

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->integer('radius_meter')->default(100);

            $table->string('kontak_nama', 100);
            $table->string('kontak_no_hp', 20);
            $table->string('kontak_email', 100);

            $table->integer('kuota');

            $table->string('mou_url', 255)->nullable();
            $table->date('mou_berlaku_sampai')->nullable();

            $table->enum('status', [
                'aktif',
                'tidak_aktif',
                'dalam_proses'
            ])->default('dalam_proses');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industri');
    }
};