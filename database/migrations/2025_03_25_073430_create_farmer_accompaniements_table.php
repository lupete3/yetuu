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
        Schema::create('farmer_accompaniements', function (Blueprint $table) {
            $table->id();
            $table->string('year')->nullable(); // Year
            $table->string('season')->nullable(); // Season
            $table->string('country')->nullable(); // Pays
            $table->string('province')->nullable(); // Province
            $table->string('site')->nullable(); // Site
            $table->string('territory')->nullable(); // Territoire
            $table->string('groupement')->nullable(); // Groupement
            $table->string('village')->nullable(); // Village
            $table->string('beneficiary_name')->nullable(); // Noms du bénéficiaire
            $table->string('gender')->nullable(); // Genre
            $table->integer('age')->nullable(); // Age
            $table->string('phone_number')->nullable(); // Numéro téléphone
            $table->string('gps_coordinates')->nullable(); // Coordonnées GPS du Champ
            $table->string('crop_sown')->nullable(); // Culture semée
            $table->string('variety')->nullable(); // Variété
            $table->decimal('seed_quantity_received', 8, 2)->nullable(); // Quantité de semence reçue (en Kg)
            $table->string('fertilizer_type')->nullable(); // Type de fertilisant
            $table->decimal('fertilizer_quantity_base', 8, 2)->nullable(); // Quantité en Kg de Fertilisant reçue/ Engrais de fond
            $table->decimal('fertilizer_quantity_surface', 8, 2)->nullable(); // Quantité en Kg de Fertilisant reçue/ Engrais de Surface
            $table->decimal('cultivated_area', 8, 2)->nullable(); // Superficie occupée par la culture
            $table->integer('training_sessions_received')->nullable(); // Nombre de formations reçues
            $table->text('training_types_received')->nullable(); // Types de formation reçues
            $table->text('additional_support_received')->nullable(); // Autre accompagnement reçu
            $table->decimal('quantity_produced', 8, 2)->nullable(); // Quantité produite (en Kg)
            $table->decimal('quantity_reimbursed', 8, 2)->nullable(); // Quantité remboursée (en Kg)
            $table->text('observations')->nullable(); // Observations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_accompaniements');
    }
};
