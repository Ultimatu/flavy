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
        Schema::table('conseils', function (Blueprint $table) {
            $table->foreignId('id_type')->constrained('type_conseils')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conseils', function (Blueprint $table) {
            $table->dropForeign('conseils_id_type_foreign');
            $table->dropColumn('id_type');
        });
    }
};
