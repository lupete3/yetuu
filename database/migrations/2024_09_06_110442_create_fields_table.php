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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_id'); // Field_id auto-generated
            $table->string('field_name');
            $table->foreignId('farmer_id')->constrained('farmers');
            $table->decimal('total_area', 8, 2);
            $table->string('soil_type')->nullable();
            $table->string('irrigation_type')->nullable();
            $table->polygon('gps_location')->nullable();
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
