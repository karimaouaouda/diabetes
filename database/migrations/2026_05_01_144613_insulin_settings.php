<?php
// database/migrations/xxxx_xx_xx_create_insulin_settings_table.php
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
        Schema::create('insulin_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('target_glucose')->default(120); // Glycémie cible en mg/dL
            $table->float('correction_factor')->default(50); // Facteur de correction en mg/dL par unité
            $table->float('carb_ratio')->default(10); // Ratio glucides en g par unité
            $table->integer('insulin_duration')->default(3); // Durée d'action de l'insuline en heures
            $table->integer('active_insulin_time')->default(4); // Temps d'insuline active en heures
            $table->timestamps();

            // Un utilisateur ne peut avoir qu'un seul enregistrement de paramètres
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insulin_settings');
    }
};
