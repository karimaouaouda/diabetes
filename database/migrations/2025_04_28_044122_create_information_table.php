<?php

use App\Enums\InformationOrder;
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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('info_type_id')
                ->constrained('information_types')
                ->cascadeOnDelete();

            $table->enum('info_order', InformationOrder::values());

            $table->float('value')->default(0.0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
