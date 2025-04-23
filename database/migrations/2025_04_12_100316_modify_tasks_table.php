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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('deadline'); // Drop the existing column
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->string('deadline')->after('title'); // Re-add it after the desired column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('deadline'); // Undo changes
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->string('deadline'); // Restore the column without `after()`
        });
    }
};

