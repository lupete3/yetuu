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
        Schema::create('farm_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms');
            $table->date('last_date_chemical_applied')->nullable();
            $table->decimal('estimated_yield', 8, 2)->nullable();
            $table->string('conventional_lands')->nullable();
            $table->string('conventional_crops')->nullable();
            $table->string('inspector_name')->nullable();
            $table->boolean('qualified_inspector')->default(false);
            $table->date('date_of_inspection')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_conversions');
    }
};
