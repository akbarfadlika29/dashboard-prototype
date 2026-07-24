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
        Schema::create('dataset_file_revision_changes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('revision_id')
                ->constrained('dataset_revisions')
                ->cascadeOnDelete();

            $table->string('action');

            $table->string('before_file_storage')->nullable();

            $table->string('after_file_storage')->nullable();

            $table->string('before_file_original_name')->nullable();

            $table->string('after_file_original_name')->nullable();

            $table->string('before_file_mime')->nullable();

            $table->string('after_file_mime')->nullable();

            $table->string('before_file_size')->nullable();

            $table->string('after_file_size')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_file_revision_changes');
    }
};
