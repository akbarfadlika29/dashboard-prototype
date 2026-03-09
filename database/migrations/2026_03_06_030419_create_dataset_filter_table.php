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
        Schema::create('dataset_filter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dataset_id')->constrained('dataset')->cascadeOnDelete();
            $table->string('kolom', 100);
            $table->timestamps();

            $table->unique(['dataset_id', 'kolom']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_filter');
    }
};
