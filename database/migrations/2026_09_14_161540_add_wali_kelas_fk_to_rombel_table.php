<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rombel', function (Blueprint $table) {
            $table->foreign('wali_kelas_guru_id')
                ->references('id')
                ->on('guru')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('rombel', function (Blueprint $table) {
            $table->dropForeign(['wali_kelas_guru_id']);
        });
    }
};