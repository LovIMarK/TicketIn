<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create cache tables.
 *
 * Tables:
 * - cache       : simple key/value store with expiration
 * - cache_locks : advisory locks for cache operations
 *
 * Notes:
 * - The primary key is the string 'key' column on both tables.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates 'cache' and 'cache_locks' tables.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops both tables.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
