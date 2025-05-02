<?php
// database/migrations/xxxx_xx_xx_create_insulin_calculations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insulin_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('blood_glucose'); // Glycémie en mg/dL
            $table->float('carbohydrates'); // Glucides en grammes
            $table->enum('meal_type', ['breakfast', 'morning', 'lunch', 'afternoon', 'dinner', 'night']);
            $table->float('correction_units'); // Unités d'insuline pour la correction
            $table->float('meal_units'); // Unités d'insuline pour le repas
            $table->float('total_units'); // Dose totale d'insuline
            $table->enum('physical_activity', ['none', 'light', 'moderate', 'intense'])->default('none');
            $table->text('notes')->nullable(); // Notes ou commentaires
            $table->boolean('administered')->default(false); // Si la dose a été administrée
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insulin_calculations');
    }
};
