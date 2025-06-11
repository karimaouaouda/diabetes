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
            $table->foreignId('patient_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->float('target_glucose')
                ->default(120); // Glycémie cible en mg/dL
            $table->float('correction_factor')
                ->default(50); // Facteur de correction en mg/dL par unité
            $table->float('carb_ratio')
                ->default(10); // Ratio glucides en g par unité
            $table->float('danger_max_bound')
                ->default(70);
            $table->float('danger_min_bound')
                ->default(70);
            $table->timestamps();
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
