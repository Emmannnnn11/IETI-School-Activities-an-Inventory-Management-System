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
        Schema::create('event_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('action')->default('deleted');
            $table->string('title');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('event_date')->nullable();
            $table->json('event_data')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->timestamp('performed_at')->nullable();
            $table->timestamps();

            $table->index('event_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_histories');
    }
};

