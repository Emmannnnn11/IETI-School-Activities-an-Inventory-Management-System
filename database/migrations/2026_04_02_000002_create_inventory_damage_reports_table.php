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
        Schema::create('inventory_damage_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_item_id')->constrained('event_items')->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->integer('quantity_damaged');
            $table->text('remarks')->nullable();
            // A simple queue so maintenance can act on damaged returns.
            $table->enum('status', ['pending', 'repaired', 'replaced'])->default('pending');
            $table->timestamps();

            $table->index(['event_item_id', 'inventory_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_damage_reports');
    }
};

