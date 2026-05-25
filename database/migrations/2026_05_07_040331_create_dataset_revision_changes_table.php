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
        Schema::create('dataset_revision_changes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('revision_id')
                ->constrained('dataset_revisions')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | ACTION
            |--------------------------------------------------------------------------
            | create_row
            | update_row
            | delete_row
            | create_column
            | update_column
            | delete_column
            | update_dataset
            | create_filter
            | update_filter
            | delete_filter
            */
            $table->string('action');

            /*
            |--------------------------------------------------------------------------
            | TARGET TYPE
            |--------------------------------------------------------------------------
            | dataset_row
            | dataset_column
            | dataset_filter
            | dataset_meta
            */
            $table->string('target_type')->nullable();

            $table->unsignedBigInteger('target_id')->nullable();

            $table->json('before_json')->nullable();

            $table->json('after_json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_revision_changes');
    }
};
