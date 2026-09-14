<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industri_jurusan', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('industri_id');
            $table->unsignedInteger('jurusan_id');

            $table->foreign('industri_id')
                ->references('id')
                ->on('industri')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique([
                'industri_id',
                'jurusan_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industri_jurusan');
    }
};