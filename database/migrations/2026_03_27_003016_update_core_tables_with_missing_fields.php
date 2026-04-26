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
        // Update Utilisateurs
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->unsignedBigInteger('equipe_id')->nullable()->after('photo_url');
        });

        // Update Employes
        Schema::table('employes', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_id')->nullable()->after('poste_id');
            $table->unsignedBigInteger('equipe_id')->nullable()->after('manager_id');
            $table->unsignedBigInteger('regle_presence_id')->nullable()->after('equipe_id');
            $table->string('statut', 20)->default('actif')->after('date_embauche'); // actif, suspendu, quitte
            $table->string('type_contrat', 20)->nullable()->after('statut'); // CDI, CDD, Stage
        });

        // Update Pointages
        Schema::table('pointages', function (Blueprint $table) {
            $table->decimal('overtime_hours', 5, 2)->default(0)->after('statut');
            $table->decimal('latitude', 10, 8)->nullable()->after('overtime_hours');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropColumn('equipe_id');
        });
        Schema::table('employes', function (Blueprint $table) {
            $table->dropColumn(['manager_id', 'equipe_id', 'regle_presence_id', 'statut', 'type_contrat']);
        });
        Schema::table('pointages', function (Blueprint $table) {
            $table->dropColumn(['overtime_hours', 'latitude', 'longitude']);
        });
    }
};
