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
        Schema::create('sowing_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('fields');
            $table->foreignId('crop_id')->constrained('crop_management');
            $table->date('sowing_date');
            $table->decimal('area_sown', 8, 2);
            $table->polygon('gps_coordinates')->nullable();
            $table->string('geo_map_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sowing_records');
    }
};
