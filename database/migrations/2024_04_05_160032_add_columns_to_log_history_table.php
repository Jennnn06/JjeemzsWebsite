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
        Schema::table('log_history', function (Blueprint $table) {
            $table->string('ITEM_CODE')->nullable();
            $table->string('ITEM_IMAGE')->nullable();
            $table->string('COLOR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_history', function (Blueprint $table) {
            //
        });
    }
};
