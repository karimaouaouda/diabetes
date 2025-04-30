<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsulinCalculationsTable extends Migration
{
    public function up()
    {
        Schema::create('insulin_calculations', function (Blueprint $table) {
            $table->id();
            $table->float('current_glucose');
            $table->float('carbs');
            $table->float('carb_ratio');
            $table->float('insulin_sensitivity');
            $table->float('target_glucose');
            $table->float('calculated_dose');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insulin_calculations');
    }
}
