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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->foreignId('departement_id')->constrained('departements')->onDelete('cascade');
            $table->foreignId('poste_id')->constrained('poste')->onDelete('cascade');
            $table->string('matricule', 50)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 191)->unique();
            $table->string('telephone', 20)->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_embauche');
            $table->enum('genre', ['M', 'F'])->default('M');
            $table->string('cin', 20)->unique()->nullable();
            $table->string('cnss', 20)->nullable();
            $table->text('adresse')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
