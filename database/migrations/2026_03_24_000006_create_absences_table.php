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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')
                  ->constrained('employes')
                  ->onDelete('cascade');
            $table->enum('type', [
                'conge_paye',
                'conge_maladie',
                'conge_maternite',
                'conge_paternite',
                'absence_injustifiee',
                'absence_justifiee',
                'conge_sans_solde',
                'autre'
            ])->default('absence_justifiee');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedBigInteger('justificatif_piece_jointe_id')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'refuse', 'annule'])
                  ->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};