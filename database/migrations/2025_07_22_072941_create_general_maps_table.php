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
        if (!Schema::hasTable('general_maps')) {
            Schema::create('general_maps', function (Blueprint $table) {
                $table->id();

                // Replace morphs() with manually sized string columns
                $table->string('mappable_type', 100);
                $table->unsignedBigInteger('mappable_id');
                $table->string('related_type', 100);
                $table->unsignedBigInteger('related_id');

                $table->string('relationship_type', 100)->default('general');
                $table->string('relationship_key', 100)->nullable();

                $table->json('metadata')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                // Unique constraint (now safe under 3072 bytes)
                $table->unique([
                    'mappable_type',
                    'mappable_id',
                    'related_type',
                    'related_id',
                    'relationship_type',
                    'relationship_key'
                ], 'unique_general_map');

                // Indexes for performance
                $table->index(['mappable_type', 'mappable_id', 'relationship_type']);
                $table->index(['related_type', 'related_id', 'relationship_type']);
                $table->index(['relationship_type', 'is_active']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('general_maps')) {
            Schema::dropIfExists('general_maps');
        }
    }
};

