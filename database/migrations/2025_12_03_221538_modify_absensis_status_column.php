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
        // First, change column to varchar to allow updates
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('status', 20)->change();
        });
        
        // Update existing records from 'telat' to 'terlambat'
        DB::table('absensis')->where('status', 'telat')->update(['status' => 'terlambat']);
        
        // Then change back to enum with new values
        Schema::table('absensis', function (Blueprint $table) {
            $table->enum('status', ['tepat_waktu', 'terlambat'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change to varchar first
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('status', 20)->change();
        });
        
        // Revert existing records
        DB::table('absensis')->where('status', 'terlambat')->update(['status' => 'telat']);
        
        // Change back to original enum values
        Schema::table('absensis', function (Blueprint $table) {
            $table->enum('status', ['tepat_waktu', 'telat'])->change();
        });
    }
};
