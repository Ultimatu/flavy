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
        Schema::table('users', function (Blueprint $table) {
            $table->string('taille')->nullable();
            $table->string('poids')->nullable();
            $table->text('maladie_chronique')->nullable();
            $table->string('sexe')->nullable();
            $table->string('carte_cmu')->nullable();
            $table->string('n_assurance')->nullable();
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable(false)->change();
            $table->foreignId('id_type_assurance')->nullable()->constrained('type_assurance')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'taille',
                'poids',
                'maladie_chronique',
                'sexe',
                'n_cmu',
                'n_assurance',
                'id_type_assurance',
            ]);
        });
    }
};
