<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Resets the event_items id sequence to match the current max(id).
     * Use this if event_items IDs have gaps or the sequence is out of sync
     * (e.g. after imports, manual inserts, or deleted rows).
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement(
            "SELECT setval(
                pg_get_serial_sequence('event_items', 'id'),
                (SELECT COALESCE(MAX(id), 1) FROM event_items),
                true
            )"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No safe way to reverse a sequence reset
    }
};
