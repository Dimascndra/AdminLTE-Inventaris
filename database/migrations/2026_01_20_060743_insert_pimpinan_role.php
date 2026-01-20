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
        DB::statement("ALTER TABLE roles MODIFY COLUMN name ENUM('admin','super_admin','staff','employee','pimpinan')");

        DB::table('roles')->insert([
            'name' => 'pimpinan',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->where('name', 'pimpinan')->delete();
        DB::statement("ALTER TABLE roles MODIFY COLUMN name ENUM('admin','super_admin','staff','employee')");
    }
};
