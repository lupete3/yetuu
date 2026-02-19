<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->index('farmer_id');
            $table->index('first_name');
            $table->index('last_name');
            $table->index('contact_number');
            $table->index('created_at');
        });

        Schema::table('farms', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('crop_management', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropIndex(['farmer_id']);
            $table->dropIndex(['first_name']);
            $table->dropIndex(['last_name']);
            $table->dropIndex(['contact_number']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('farms', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('crop_management', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
};
