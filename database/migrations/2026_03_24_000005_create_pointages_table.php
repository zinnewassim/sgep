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
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')
                  ->constrained('employes')
                  ->onDelete('cascade');
            $table->date('date');
            $table->time('heure_entree')->nullable();
            $table->time('heure_sortie')->nullable();
            $table->enum('source', ['manuel', 'badge', 'biometrique', 'application'])
                  ->default('manuel');
            $table->enum('statut', ['present', 'retard', 'absent', 'demi_journee'])
                  ->default('present');
            $table->timestamps();

            // Un employé ne peut avoir qu'un seul pointage par jour
            $table->unique(['employe_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
    }
};