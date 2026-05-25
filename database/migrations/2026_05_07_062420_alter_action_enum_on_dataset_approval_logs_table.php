<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NORMALIZE INVALID VALUES
        |--------------------------------------------------------------------------
        */

        DB::statement("
            UPDATE dataset_approval_logs
            SET action = 'submit'
            WHERE action IS NULL
               OR action = ''
        ");

        /*
        |--------------------------------------------------------------------------
        | ALTER ENUM
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE dataset_approval_logs
            MODIFY action ENUM(
                'submit',
                'approve',
                'reject',
                'submit_revision',
                'approve_revision',
                'reject_revision'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE dataset_approval_logs
            MODIFY action ENUM(
                'submit',
                'approve',
                'reject'
            ) NOT NULL
        ");
    }
};
