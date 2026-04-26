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
        Schema::table('pointages', function (Blueprint $table) {
            $table->decimal('latitude_entree', 10, 8)->nullable();
            $table->decimal('longitude_entree', 11, 8)->nullable();
            $table->decimal('latitude_sortie', 10, 8)->nullable();
            $table->decimal('longitude_sortie', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pointages', function (Blueprint $table) {
            $table->dropColumn(['latitude_entree', 'longitude_entree', 'latitude_sortie', 'longitude_sortie']);
        });
    }
};
