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
        Schema::create('general_meta', function (Blueprint $table) {
            $table->id();
            $table->morphs('metable'); // This creates metable_type and metable_id columns
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, float, boolean, json, etc.
            $table->timestamps();

            // Add unique constraint to prevent duplicate keys for the same model
            $table->unique(['metable_type', 'metable_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_meta');
    }
};

