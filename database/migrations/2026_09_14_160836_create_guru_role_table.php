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
        Schema::create('guru_role', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('guru_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('rombel_id')->nullable();
            $table->unsignedInteger('jurusan_id')->nullable();

            $table->foreign('guru_id')
                ->references('id')
                ->on('guru')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('role')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('rombel_id')
                ->references('id')
                ->on('rombel')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_role');
    }
};