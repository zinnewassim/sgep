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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 191)->unique();
            $table->string('telephone', 20)->nullable();
            $table->string('mot_de_passe');
            $table->enum('etat', ['actif', 'inactif', 'suspendu'])->default('actif');
            $table->timestamp('derniere_connexion_at')->nullable();
            $table->string('photo_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};