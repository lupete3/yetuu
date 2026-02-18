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
        Schema::create('crop_management', function (Blueprint $table) {
            $table->id();
            $table->string('growing_season'); // Saison de croissance
            $table->string('crop_id'); // Identifiant unique de la culture
            $table->foreignId('farmer_id')->constrained('farmers'); // Référence à l'ID du fermier
            $table->string('crop_type'); // Type de culture (par exemple, maïs, riz)
            $table->string('variety_name')->nullable(); // Nom de la variété
            $table->string('disease_resistance')->nullable(); // Résistance aux maladies
            $table->integer('growth_duration')->nullable(); // Durée de croissance (en jours)
            $table->string('fertilizer_requirements')->nullable(); // Besoins en engrais
            $table->date('planting_date'); // Date de plantation
            $table->date('harvest_date')->nullable(); // Date de récolte (optionnelle)
            $table->string('growth_stage')->nullable(); // Stade de croissance (par exemple, germination, floraison)
            $table->string('photo')->nullable(); // Photo de la culture
            $table->timestamps(); // Marqueurs temporels pour la création et la mise à jour
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_management');
    }
};
