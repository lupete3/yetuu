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
        Schema::table('farmers', function (Blueprint $table) {

            $table->date('join_date')->nullable()->after('contact_number');
            $table->unsignedBigInteger('accompaniement_id')->nullable()->after('join_date'); // Ajoute accompaniement_id
            $table->foreign('accompaniement_id')->references('id')->on('accompaniements')->onDelete('cascade');
            $table->string('priority_culture')->nullable()->after('accompaniement_id');
            $table->boolean('status')->default(true)->after('account_number');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropForeign(['accompaniement_id']); // Supprime la clé étrangère si elle existe
            $table->dropColumn('accompaniement_id'); // Supprime la colonne
        });
    }
};
