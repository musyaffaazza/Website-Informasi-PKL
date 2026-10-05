<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('jurusan', 'akreditasi')) {
            return;
        }

        Schema::table('jurusan', function (Blueprint $table) {
            $table->dropColumn('akreditasi');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('jurusan', 'akreditasi')) {
            return;
        }

        Schema::table('jurusan', function (Blueprint $table) {
            $table->string('akreditasi', 50)->nullable()->after('status');
        });
    }
};
