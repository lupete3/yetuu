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
        Schema::create('farms', function (Blueprint $table) {
            $table->id(); // Primary key auto-generated
            $table->string('farm_id')->unique(); // Farm ID auto-generated as string
            $table->foreignId('farmer_id')->constrained('farmers');
            $table->string('farm_name');
            $table->string('previous_cultivated_crop')->nullable();
            $table->string('address');
            $table->decimal('proposed_planting_area', 20, 2);
            $table->string('land_topography');
            $table->decimal('total_land_holding', 20, 2);
            $table->enum('land_ownership', ['own_by_family', 'own_by_individual', 'renting'])->default('renting');
            $table->string('nearby')->nullable();
            $table->string('gps_location')->nullable();
            $table->string('photo')->nullable();
            $table->json('documents_upload')->nullable();
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
