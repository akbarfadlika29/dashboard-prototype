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
        Schema::create('dataset_approval_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dataset_id')->constrained('dataset')->cascadeOnDelete();
            $table->enum('action', ['approve', 'reject', 'cancel']);
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_approval_logs');
    }
};
