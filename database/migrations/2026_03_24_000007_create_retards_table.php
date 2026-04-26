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
        Schema::create('retards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')
                  ->constrained('employes')
                  ->onDelete('cascade');
            $table->date('date');
            $table->unsignedInteger('minutes')->default(0)
                  ->comment('Nombre de minutes de retard par rapport à l\'heure de début prévue');
            $table->text('motif')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Un employé ne peut avoir qu'un seul retard enregistré par jour
            $table->unique(['employe_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retards');
    }
};