<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('industri', function (Blueprint $table) {
            if (!Schema::hasColumn('industri', 'logo_url')) {
                $table->string('logo_url', 255)->nullable()->after('nama');
            }
        });
    }
    public function down(): void {
        Schema::table('industri', function (Blueprint $table) {
            $table->dropColumn('logo_url');
        });
    }
};
