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
        // On Postgres we already defined the full enum (including 'Head Maintenance')
        // when creating the users table, so we only need to run the ALTER for MySQL/MariaDB.
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'college_head', 'senior_head', 'junior_head', 'teacher', 'staff', 'Head Maintenance') DEFAULT 'teacher'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            // Revert to the original enum without 'Head Maintenance'
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'college_head', 'senior_head', 'junior_head', 'teacher', 'staff') DEFAULT 'teacher'");
        }
    }
};
