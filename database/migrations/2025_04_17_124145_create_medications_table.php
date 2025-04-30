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
        // database/migrations/..._create_medications_table.php
Schema::create('medications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('dosage');
    $table->json('times'); // Stocke les heures sous forme ['08:00', '14:00', '20:00']
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->boolean('notifications_enabled')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
