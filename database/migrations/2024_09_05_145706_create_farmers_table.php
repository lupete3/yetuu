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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('farmer_id'); // Farmer_id auto-generated
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();;
            $table->string('gender')->nullable();;

            // Foreign key relations for automatic country, province, territory selection
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('state_province_id')->constrained('provinces');
            $table->foreignId('territory_id')->constrained('territories');

            $table->unsignedBigInteger('groupement_id')->nullable(); // Ajoute groupement_id
            $table->foreign('groupement_id')->references('id')->on('groupements')->onDelete('cascade');

            $table->string('village')->nullable();;
            $table->string('operational_site')->nullable();;
            $table->integer('number_of_family_members')->nullable();;

            // Additional fields
            $table->string('main_occupation')->nullable();;
            $table->string('level_of_education')->nullable();;
            $table->string('civil_status')->nullable();;
            $table->boolean('is_member_of_association')->nullable();; // Yes/No field for membership
            $table->string('association_name')->nullable(); // Nullable if not a member
            $table->string('contact_number');
            $table->string('photo')->nullable(); // Capture or insert photo field
            $table->enum('doc_type', ['passport', 'voting_card_id', 'driving_lisence'])->default('voting_card_id');

            // Bank details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
