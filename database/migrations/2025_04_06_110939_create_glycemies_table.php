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
        Schema::dropIfExists('glycemies');
        Schema::create('glycemies', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('valeur', 4, 1);
            $table->date('date_mesure');
            $table->time('heure_mesure');
            $table->string('moment');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glycemies');
    }
};
