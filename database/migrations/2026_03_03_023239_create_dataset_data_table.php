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
        Schema::create('dataset_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dataset_id')->constrained('dataset')->cascadeOnDelete();
            $table->year('tahun')->index();
            $table->json('data_json');
            $table->timestamps();
            $table->index(['dataset_id', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_data');
    }
};
