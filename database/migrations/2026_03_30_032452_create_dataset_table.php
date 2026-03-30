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
        Schema::create('dataset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->foreignId('seksi_id')->constrained('seksi')->cascadeOnDelete();
            $table->string('nama', 200);
            $table->string('slug', 200)->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('schema_json');
            $table->json('kolom');
            $table->string('tipe_grafik_default', 50)->nullable();
            $table->enum('status', ['draft','pending','approved','rejected'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['kategori_id', 'seksi_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset');
    }
};
