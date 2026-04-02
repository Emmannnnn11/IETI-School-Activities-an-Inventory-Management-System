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
        Schema::table('event_items', function (Blueprint $table) {
            if (!Schema::hasColumn('event_items', 'quantity_returned')) {
                $table->integer('quantity_returned')->nullable()->after('returned_at');
            }

            if (!Schema::hasColumn('event_items', 'quantity_damaged')) {
                $table->integer('quantity_damaged')->nullable()->after('quantity_returned');
            }

            if (!Schema::hasColumn('event_items', 'quantity_accepted')) {
                $table->integer('quantity_accepted')->nullable()->after('quantity_damaged');
            }

            if (!Schema::hasColumn('event_items', 'return_remarks')) {
                $table->text('return_remarks')->nullable()->after('quantity_accepted');
            }

            if (!Schema::hasColumn('event_items', 'return_status')) {
                $table->enum('return_status', ['completed', 'partially_accepted', 'damaged'])
                    ->nullable()
                    ->after('return_remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_items', function (Blueprint $table) {
            if (Schema::hasColumn('event_items', 'return_status')) {
                $table->dropColumn('return_status');
            }
            if (Schema::hasColumn('event_items', 'return_remarks')) {
                $table->dropColumn('return_remarks');
            }
            if (Schema::hasColumn('event_items', 'quantity_accepted')) {
                $table->dropColumn('quantity_accepted');
            }
            if (Schema::hasColumn('event_items', 'quantity_damaged')) {
                $table->dropColumn('quantity_damaged');
            }
            if (Schema::hasColumn('event_items', 'quantity_returned')) {
                $table->dropColumn('quantity_returned');
            }
        });
    }
};

