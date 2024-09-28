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
        Schema::table('user', function (Blueprint $table) {
            $table->string('foto')->nullable(); // Add a new column for the profile photo
        });
    }
    
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('foto'); // Rollback the added column
        });
    }
    
};
