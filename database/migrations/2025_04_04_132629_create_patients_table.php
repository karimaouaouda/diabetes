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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom du patient (VARCHAR)
            $table->string('prenom')->nullable(); // Prénom du patient (VARCHAR), peut être nul
            $table->date('date_naissance')->nullable(); // Date de naissance du patient (DATE), peut être nulle
            $table->string('adresse')->nullable(); // Adresse du patient (VARCHAR), peut être nulle
            $table->string('telephone')->nullable(); // Numéro de téléphone du patient (VARCHAR), peut être nul
            $table->string('email')->nullable()->unique(); // Adresse e-mail du patient (VARCHAR), peut être nulle et doit être unique
            // Ajoutez ici d'autres colonnes spécifiques à vos besoins

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
