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
        Schema::create('dataset_revisions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('dataset_id')
                ->constrained('dataset')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            | draft
            | pending
            | approved
            | rejected
            */
            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected'
            ])->default('draft');

            $table->text('catatan')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_revisions');
    }
};
