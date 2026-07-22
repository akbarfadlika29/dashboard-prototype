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
        Schema::table('dataset', function (Blueprint $table) {
            $table->json('schema_json')->nullable()->change();
            $table->json('kolom')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataset', function (Blueprint $table) {
            $table->json('schema_json')->nullable(false)->change();
            $table->json('kolom')->nullable(false)->change();
        });
    }
};
