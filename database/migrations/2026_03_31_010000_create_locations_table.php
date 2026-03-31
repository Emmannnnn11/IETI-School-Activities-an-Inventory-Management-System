<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Seed predefined locations for the event form dropdown
        $now = now();
        $locations = [
            'Covered Court',
            'Open Court 1',
            'Open Court 2',
            'Sipag Hall',
            'Junior High School Computer Laboratory',
            'College Computer Laboratory 1',
            'College Computer Laboratory 2',
            'Studio',
        ];

        foreach ($locations as $location) {
            DB::table('locations')->insert([
                'name' => $location,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

