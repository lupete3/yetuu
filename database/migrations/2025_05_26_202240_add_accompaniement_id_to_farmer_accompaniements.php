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
        Schema::table('farmer_accompaniements', function (Blueprint $table) {

            $table->unsignedBigInteger('accompaniement_id')->nullable()->after('observations'); // Ajoute accompaniement_id
            $table->foreign('accompaniement_id')->references('id')->on('accompaniements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmer_accompaniements', function (Blueprint $table) {
            $table->dropForeign(['accompaniement_id']); // Supprime la clé étrangère si elle existe
            $table->dropColumn('accompaniement_id'); // Supprime la colonne
        });
    }
};
