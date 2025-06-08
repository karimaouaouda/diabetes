<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('followings', function (Blueprint $table) {
            $table->string('status')->default('pending');
            $table->unique('patient_id');
        });
    }

    public function down(): void
    {
        Schema::table('followings', function (Blueprint $table) {
            $table->dropUnique(['patient_id']);
            $table->dropColumn('status');
        });
    }
};
